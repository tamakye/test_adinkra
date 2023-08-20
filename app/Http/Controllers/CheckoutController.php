<?php

namespace App\Http\Controllers;

use App\Events\OrderPlacedEvent;
use App\Http\Requests\CheckoutRequest;
use App\Models\Country;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Traits\ShippingTrait;
use App\Traits\VatTrait;
use Cart;
use Darryldecode\Cart\CartCondition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Paystack;

class CheckoutController extends Controller
{
    use VatTrait, ShippingTrait;

    public function showCheckoutPage(){

        // Cart::session(get_cart_id())->removeCartCondition('shipping');

        if(Cart::session(get_cart_id())->isEmpty()){
            return to_route('cart');
        }

        $products =  Cart::session(get_cart_id())->getContent();
        $countries = Country::orderby('name')->get();
        $address  =  Auth::check() ?  Auth::user()->addresses()->where('default', 1)->first() : null;

        return view('front-end.orders.checkout', compact('products', 'countries', 'address'));
    }


    // public function ProcessPayment(Request $request)
    public function ProcessPayment(CheckoutRequest $request)
    {
        if($request->payment_type == 'paystack'){

            $payment_type = 'paystack';
            $payment_method = 'card';
            $payment_date = null;
            $isPaid = 0;

        }elseif($request->payment_type == 'bank'){
            $payment_type = 'bank';
            $payment_method = 'Bank Deposit';
            $payment_date = null;
            $isPaid = 0;
        }else{
            // cash on delivery
            $payment_type = 'cash_on_delivery';
            $payment_method = 'Cash';
            $payment_date = null;
            $isPaid = 0;

        }


        if ($this->hasShipping()) {
            // shipping to different address

            $address = $this->createShippingAddress($request);

        }else{

            $address =  $this->createSameAddress($request);
        }


        // create order
        $order = Order::create([
            'order_number' => get_order_number(),
            'order_date' => now(),
            'user_id' => Auth::check() ? Auth::id() : null,
            'user' => set_wishlist_id(),
            'address_id' => $address->id,
            'coupon' => !empty(getCouponCondition()) ? getCouponCondition()->getAttributes()['coupon'] : null,
            'coupon_amount' => !empty(getCouponCondition()) ? getCouponValue() : null,
            'subtotal' => getsubTotalAmount(),
            'shipping_method' => getShippingCondition()->getAttributes()['shipping_location'],
            'shipping_amount' => getShippingValue(),
            'vat' => getVatValue(),
            'total_items' => getCartQuantity(),
            'grand_total' => getTotalOrderAmount(),
            'isPaid' => $isPaid,
            'payment_type' => $payment_type,
            'payment_date' => $payment_date,
            'payment_method' => $payment_method,
            'ip_address' => request()->ip(),
            'transaction_id' => strtotime(now()),
            'order_notes' => $request->order_notes,
        ]);

        // created order items
        $products =  Cart::session(get_cart_id())->getContent();

        $order_items = collect([]);

        foreach ($products as $product){
            $items = [];
            $items['order_id'] = $order->id;
            $items['product_id'] = $product->model->id;
            $items['quantity'] = $product->quantity;
            $items['price'] = $product->price;
            $items['total'] = ($product->price * $product->quantity);

            $order_items->push($items);

            $this->updateStock($product->model->id, $product->quantity);
        }

        $order->products()->sync($order_items);

        // process paystack payment
        if($request->payment_type == 'paystack'){

            $paystack_payload = array(
                "order_id" => $order->order_number,
                "amount" => $order->grand_total * 100,
                'reference' => $order->transaction_id,
                'first_name' =>  $request->billing_first_name,
                'email' => $request->billing_email,
                'phone' => $request->billing_phone,
                'description' => "Order placement",
                'currency' => config('adinkra.currency'),
                'callback_url' => route('payments.callback'),
                'channels' => ['mobile_money', 'card', 'bank', 'ussd', 'qr', 'bank_transfer'],
            );

            return Paystack::getAuthorizationUrl($paystack_payload)->redirectNow();

        }else{

            $this->clearUserCart($order);
        }

        \Session::flash('success', 'Order has been placed successfully');

        return redirect()->route('orders.summary', $order->order_number);
    }


    public function clearUserCart($order){
        // send order notifaction
        event(new OrderPlacedEvent($order));

            // clear cart
        Cart::session(get_cart_id())->clear();
            // clear conditions
        $this->clearConditions();

    }

    /**
     * Obtain Paystack payment information
     * @return void
     */
    public function handleGatewayCallback()
    {
        $paymentDetails = Paystack::getPaymentData();

        $order = Order::where('transaction_id', $paymentDetails['data']['reference'])->first();

        $order->update([
            'payment_type' => 'paystack',
            'payment_method' => $paymentDetails['data']['channel'],
            'payment_date' => $paymentDetails['data']['paid_at'],
            'isPaid' => 1,
        ]);

        $this->clearUserCart($order);

        return to_route('orders.summary', $order->order_number)->with('success', 'Order has been placed successfully');
    }
    /**
     * order summary page
     *
     * @param      <type>  $order_number  The order number
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function orderSummary($order_number){

        $order = Order::with(['products', 'addresses'])->where('order_number', $order_number)->firstOrfail();

        return view('front-end.orders.order-summary', compact('order'));

    }


    public function updateStock($id, $quantity){

        $product = Product::find($id);

        $product->quantity_in_stock = $product->quantity_in_stock - $quantity;
        $product->save();

    }


    public function LoadAddress(Request $request){

        $address = [];

        // if the request is an authenticated user order
        if ($request->status == 'user') {
            $user = User::find($request->customer);

            $address = $user->addresses()->where(['user_id' => $user->id, 'default' => 1])->first();
        }else{

            // if the request is a guest distributor order
            $order = Order::where('order_number', $request->customer)->first();

            $address = $order->addresses()->where(['default' => 1])->first();

        }
        

        if (!empty($address)) {
            $address_data = [

                'billing_first_name' =>  $address->billing_first_name,
                'billing_last_name' =>  $address->billing_last_name,
                'billing_address_one' =>  $address->billing_address_one,
                'billing_address_two' =>  $address->billing_address_two,
                'billing_country' =>  $address->billing_country,
                'billing_region' =>  $address->billing_region,
                'billing_city' =>  $address->billing_city,
                'billing_zip_code' =>  $address->billing_zip_code,
                'billing_phone' =>  $address->billing_phone,
                'billing_email' =>  $address->billing_email,
                
                'shipping_first_name' =>  $address->shipping_first_name,
                'shipping_last_name' =>  $address->shipping_last_name,
                'shipping_address_one' =>  $address->shipping_address_one,
                'shipping_address_two' =>  $address->shipping_address_two,
                'shipping_country' =>  $address->shipping_country,
                'shipping_region' =>  $address->shipping_region,
                'shipping_city' =>  $address->shipping_city,
                'shipping_zip_code' =>  $address->shipping_zip_code,
                'shipping_phone' =>  $address->shipping_phone,
                'shipping_email' =>  $address->shipping_email,
            ];

        }else{
            $address_data = [
                'billing_first_name' =>    $user->first_name,
                'billing_last_name' =>   $user->last_name,
                'billing_email' =>  $user->email,
                'billing_phone' =>  $user->phone,
            ];
        }

        return response()->json($address_data);
    }
}
