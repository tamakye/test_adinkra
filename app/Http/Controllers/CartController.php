<?php

namespace App\Http\Controllers;

use App\Models\Attributevalue;
use App\Models\Country;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\Shipping;
use App\Traits\VatTrait;
use Cart;
use Darryldecode\Cart\CartCondition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    use VatTrait;

    public function showCart(){

        $products =  Cart::session(get_cart_id())->getContent();
        // $this->clearCondtions();

        if ((count($products) > 0) && !$this->hasVAT()) {
            $this->add_vat();
        }

        return view('front-end.orders.cart', compact('products'));
    }



    /**
     * Adds to cart.
     *
     * @param      \Illuminate\Http\Request  $request  The request
     *
     * @return     <type>                    ( description_of_the_return_value )
     */
    public function addToCart(Request $request){

        $attributevalue = Attributevalue::whereSlug($request->attributevalue)->first();

        if(!empty($attributevalue)){
            $product = Product::with(['attributes' => function($query) use ($attributevalue){
                $query->wherePivot('attributevalue_id', $attributevalue->id)->first();
            }])->where('slug', $request->product)->firstOrfail();

        }else{
            $product = Product::with('attributes')->where('slug', $request->product)->firstOrfail();
        }


        // if (!empty($product->mustanglabel_id) && !$this->isProtected($product)) {
        //     return response()->json(['error' => 'You are not authorized to purchase this product.']);
        // }

        if (count($product->attributes) > 0) {
            $price = $product->attributes[0]->pivot->attribute_price;
            $attr = [
                'name' => $product->attributes[0]->name,
                'title' =>  $attributevalue->title,
                'slug' =>   $product->attributes[0]->slug,
                'value_slug' => $attributevalue->slug,
            ];
        }else{
            $price = $product->price;
            $attr = [];
        }

        // add the product to cart
        $cart = Cart::session(get_cart_id())->add(array(
            'id' => $product->id,
            'name' =>$product->name,
            'price' =>  $price,
            'quantity' => 1,
            'attributes' => $attr,
            'associatedModel' => $product
        ));

        return response()->json(['success' => 'Item added to cart']);
    }


    /**
     * Adds to cart.
     *
     * @param      \Illuminate\Http\Request  $request  The request
     */
    public function updateCart(Request $request){

        $items = json_decode($request->items);
        $quantity = json_decode($request->quantity);

        for ($i = 0; $i < count($items); $i++) { 
            Cart::session(get_cart_id())->update($items[$i], array(
                'quantity' => array(
                    'relative' => false,
                    'value' => $quantity[$i]
                ),
            ));
        }

        return response()->json(['success' => 'cart has been updated.']);
    }


    /**
     * Removes an item from cart.
     *
     * @param      \Illuminate\Http\Request  $request  The request
     */
    public function removeItemFromCart(Request $request){

        Cart::session(get_cart_id())->remove($request->item_id);

        return response()->json(['success' => 'Item removed from cart']);
    }

    /**
     * calculates the shipping cost
     *
     * @param      \Illuminate\Http\Request  $request  The request
     *
     * @return     \Illuminate\Http\Request  ( description_of_the_return_value )
     */
    public function calculatShippingCost(Request $request){

        $validator = Validator::make($request->all(), [
            'shipping_country' => ['required'],
            'shipping_county' => ['nullable', 'string', 'max:255'],
            'shipping_city' => ['nullable', 'string', 'max:255'],
            'shipping_postcode' => ['nullable', 'string', 'max:255'],
        ]);


        if ($validator->fails()) {

            return response()->json(['error' => $validator->errors()->all()]);
            exit;
        }


        $country = Country::where('id', $request->shipping_country)->first();

        $shipping = $country->shippings()->first();

        if (empty($shipping)) {

            $shipping = Shipping::where('default', 1)->first();
        }


        if ($this->hasCondition('shipping')) {

            Cart::session(get_cart_id())->removeCartCondition('shipping');
        }

        $this->apply_shipping_cost($country, $shipping);


        return response()->json(['success' => 'Shipping added successfully']);

    }


    /**
     * Applies a coupon to cart
     *
     * @param      \Illuminate\Http\Request  $request  The request
     *
     * @return     \Illuminate\Http\Request  ( description_of_the_return_value )
     */
    public function applyCoupon(Request $request){

        $validator = Validator::make($request->all(), [
            'coupon' => 'required', 'string', 'max:50',
        ]);


        if ($validator->fails()) {

            return response()->json(['error' => 'Coupon can not be empty']);
        }

        $request_coupon = $request->coupon;

        // fetch coupon
        $coupon  = Coupon::where('coupon', $request_coupon)->first();
        // check if coupon exist
        if (empty($coupon)) {

            return response()->json(['error' => 'Enter a valid coupon code']);
            exit();
        }

        // // check if coupon is used
        // if (Order::where(['coupon' =>  $request_coupon])->first()) {
        //     return response()->json(['error' => 'This coupon has already been used.']);
        // }

        // clear old condition
        if ($this->hasCondition('coupon')) {

            Cart::session(get_cart_id())->removeCartCondition('coupon');
        }

        $message = 'Coupon could not be applied, please enter a valid coupon and try again later.';

        // ==============apply on unlimited===============
        
        // apply if user
        if (($coupon->apply_on == 'user' && Auth::check() && $coupon->unlimited ==  'yes' && !empty($coupon->end_date) && $this->has_ended($coupon) == false && Auth::id() == $coupon->user_id) || ($coupon->apply_on == 'user' && Auth::check() && $coupon->unlimited ==  'yes' && $coupon->expires ==  'yes' && Auth::id() == $coupon->user_id)) {

            $this->apply_coupon($coupon);

            $message = 'Coupon applied successfully';
        }

        // apply on product
        if (($coupon->apply_on == 'product' && $coupon->unlimited ==  'yes' && !empty($coupon->end_date) && $this->has_ended($coupon) == false && Product::find($coupon->product_id)) || ($coupon->apply_on == 'product' && $coupon->unlimited ==  'yes' && $coupon->expires ==  'yes' && Product::find($coupon->product_id)) ) {

            $products =  Cart::session(get_cart_id())->getContent();
            foreach ($products as $product){
                if ($product->model->id == $coupon->product_id) {

                    $this->apply_coupon_on_product($coupon, $product->model->id);
                    $message = 'Coupon applied successfully';

                    continue;
                }
            }

        }

        // apply on min order amount
        if (($coupon->apply_on == 'order_amount' && $coupon->unlimited == 'yes' && !empty($coupon->end_date) && $this->has_ended($coupon) == false && getsubTotalAmount() > $coupon->min_order_amount) || ($coupon->apply_on == 'order_amount' &&  $coupon->unlimited == 'yes' && $coupon->expires ==  'yes' && getsubTotalAmount() > $coupon->min_order_amount)) {

            $this->apply_coupon($coupon);
            $message = 'Coupon applied successfully';
        }

        // apply on all orders
        if (($coupon->apply_on == 'all_orders' && $coupon->unlimited == 'yes' && !empty($coupon->end_date) && $this->has_ended($coupon) == false) || ($coupon->apply_on == 'all_orders' &&  $coupon->unlimited == 'yes' && $coupon->expires ==  'yes')) {
            $this->apply_coupon($coupon);
            $message = 'Coupon applied successfully';
        }


        // ==============apply on limited=============
            // apply if user
        if (($coupon->apply_on == 'user' && Auth::check() && empty($coupon->unlimited) && ! empty($coupon->end_date) && $this->total_used() <= $coupon->quantity && Auth::id() == $coupon->user_id)  ||  ($coupon->apply_on == 'user' && Auth::check() && empty($coupon->unlimited) && $this->total_used() <= $coupon->quantity && $coupon->expires ==  'yes' && Auth::id() == $coupon->distributor_id)) {
            $this->apply_coupon($coupon);
            $message = 'Coupon applied successfully';
        }

        // apply on product
        if (($coupon->apply_on == 'product' && empty($coupon->unlimited) && !empty($coupon->end_date) && $this->total_used() <= $coupon->quantity && Product::find($coupon->product_id)) || ($coupon->apply_on == 'product' &&  empty($coupon->unlimited) && $coupon->expires ==  'yes' && $this->total_used() <= $coupon->quantity && Product::find($coupon->product_id))) {

            $products =  Cart::session(get_cart_id())->getContent();
            foreach ($products as $product){
                if ($product->model->id == $coupon->product_id) {

                    $this->apply_coupon_on_product($coupon, $product->model->id);
                    $message = 'Coupon applied successfully';

                    continue;
                }
            }

        }

        // apply on min order amount
        if (($coupon->apply_on == 'order_amount' && empty($coupon->unlimited) && !empty($coupon->end_date) && $this->total_used() <= $coupon->quantity && getsubTotalAmount() > $coupon->min_order_amount) || ($coupon->apply_on == 'order_amount' &&  empty($coupon->unlimited) && $this->total_used() <= $coupon->quantity && $coupon->expires ==  'yes' && getsubTotalAmount() > $coupon->min_order_amount)) {

            $this->apply_coupon($coupon);
            $message = 'Coupon applied successfully';
        }

        // apply on all orders
        if (($coupon->apply_on == 'all_orders' && empty($coupon->unlimited) && !empty($coupon->end_date) && $this->total_used() <= $coupon->quantity) || ($coupon->apply_on == 'all_orders' &&  empty($coupon->unlimited) && $coupon->expires ==  'yes' && $this->total_used() <= $coupon->quantity)) {
            return 'limited';
            $this->apply_coupon($coupon);
            $message = 'Coupon applied successfully';
        }


        return response()->json(['info' => $message]);

    }

    /**
     * Determines if ended.
     *
     * @param      <type>  $coupon  The coupon
     *
     * @return     bool    True if ended, False otherwise.
     */
    public function has_ended($coupon){
        return $coupon->end_date->format('d-m-Y H:i') < now()->format('d-m-Y H:i');
    }

    /**
     * Determines the total coupon used
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function total_used(){
        return Order::where('coupon', request()->coupon)->count();
    }
}
