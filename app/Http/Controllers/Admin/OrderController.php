<?php

namespace App\Http\Controllers\Admin;

use App\Events\OrderPlacedEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use App\Models\Order;
use App\Models\Product;
use App\Models\Tax;
use App\Traits\OrderTrait;
use App\Traits\ShippingTrait;
use App\Models\User;
use Cart;
use Darryldecode\Cart\CartCondition;
use Illuminate\Http\Request;
use Validator;

class OrderController extends Controller
{	
	use OrderTrait, ShippingTrait;

	/**
	 * Gets the orders.
	 *
	 * @return     <type>  The orders.
	 */
	public function getOrders(){

		$type = request()->type;
		$orders = $this->filterOrders();

		$all_orders = Order::latest()->limit(100)->get();
		$bin = Order::onlyTrashed()->limit(100)->get();
		$processing = Order::where('status', 'processing')->limit(100)->get();
		$pending = Order::where('status', 'pending')->limit(100)->get();
		$completed = Order::where('status', 'completed')->limit(100)->get();
		$cancelled = Order::where('status', 'cancelled')->limit(100)->get();
		$on_hold = Order::where('status', 'on-hold')->limit(100)->get();
		$refunded = Order::where('status', 'refunded')->limit(100)->get();
		$failed = Order::where('status', 'failed')->limit(100)->get();

		return view('admin.orders.index', compact('type', 'orders', 'all_orders', 'bin', 'pending', 'processing', 'completed', 'cancelled','on_hold', 'refunded', 'failed'));
	}

	/**
	 * filter Orders
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function filterOrders(){

		$type = request()->type;
		$searchTerm = request()->q ?? '';

		switch ($type) {

			case $type == 'trash':
			$orders = Order::onlyTrashed()->whereLike(['order_number', 'order_date', 'status', 'addresses.billing_email', 'addresses.billing_phone' , 'addresses.billing_first_name', 'addresses.billing_last_name', 'addresses.shipping_first_name', 'addresses.shipping_last_name', 'products.name'], $searchTerm)->where('status', 'trash')->get();
			break;

			case $type == 'processing':
			$orders = Order::whereLike(['order_number', 'order_date', 'status', 'addresses.billing_email', 'addresses.billing_phone' , 'addresses.billing_first_name', 'addresses.billing_last_name', 'addresses.shipping_first_name', 'addresses.shipping_last_name', 'products.name'], $searchTerm)->where('status', 'processing')->get();
			break;

			case $type == 'pending':
			$orders = Order::whereLike(['order_number', 'order_date', 'status', 'addresses.billing_email', 'addresses.billing_phone' , 'addresses.billing_first_name', 'addresses.billing_last_name', 'addresses.shipping_first_name', 'addresses.shipping_last_name', 'products.name'], $searchTerm)->where('status', 'pending')->get();
			break;

			case $type == 'completed':
			$orders = Order::whereLike(['order_number', 'order_date', 'status', 'addresses.billing_email', 'addresses.billing_phone' , 'addresses.billing_first_name', 'addresses.billing_last_name', 'addresses.shipping_first_name', 'addresses.shipping_last_name', 'products.name'], $searchTerm)->where('status', 'completed')->get();
			break;

			case $type == 'cancelled':
			$orders = Order::whereLike(['order_number', 'order_date', 'status', 'addresses.billing_email', 'addresses.billing_phone' , 'addresses.billing_first_name', 'addresses.billing_last_name', 'addresses.shipping_first_name', 'addresses.shipping_last_name', 'products.name'], $searchTerm)->where('status', 'cancelled')->get();
			break;

			case $type == 'on-hold':
			$orders = Order::whereLike(['order_number', 'order_date', 'status', 'addresses.billing_email', 'addresses.billing_phone' , 'addresses.billing_first_name', 'addresses.billing_last_name', 'addresses.shipping_first_name', 'addresses.shipping_last_name', 'products.name'], $searchTerm)->where('status', 'on-hold')->get();
			break;

			case $type == 'refunded':
			$orders = Order::whereLike(['order_number', 'order_date', 'status', 'addresses.billing_email', 'addresses.billing_phone' , 'addresses.billing_first_name', 'addresses.billing_last_name', 'addresses.shipping_first_name', 'addresses.shipping_last_name', 'products.name'], $searchTerm)->where('status', 'refunded')->get();
			break;

			case $type == 'failed':
			$orders = Order::whereLike(['order_number', 'order_date', 'status', 'addresses.billing_email', 'addresses.billing_phone' , 'addresses.billing_first_name', 'addresses.billing_last_name', 'addresses.shipping_first_name', 'addresses.shipping_last_name', 'products.name'], $searchTerm)->where('status', 'failed')->get();
			break;
			
			default:
			$orders = Order::whereLike(['order_number', 'order_date', 'status', 'addresses.billing_email', 'addresses.billing_phone' , 'addresses.billing_first_name', 'addresses.billing_last_name', 'addresses.shipping_first_name', 'addresses.shipping_last_name', 'products.name'], $searchTerm)->latest()->get();
			break;

		}

		return $orders;
	}

	/**
	 * Fetches an order.
	 *
	 * @param      \Illuminate\Http\Request  $request  The request
	 *
	 * @return     <type>                    The order.
	 */
	public function fetchOrder(Request $request){

		$order = Order::where('order_number', $request->slug)->first();

		return view('admin.orders.order-modal-content', compact('order'))->render();
	}


	/**
	 * Updates an order
	 *
	 * @param      \Illuminate\Http\Request  $request  The request
	 *
	 * @return     <type>                    ( description_of_the_return_value )
	 */
	public function updateOrder(Request $request){

		// get update type
		$type = $request->type;

		switch ($type) {
			case $type == 'bulk':
			$this->updateBulkOrder();
			break;
			
			default:
			// update single order
			$this->updateSingleOrder();
			break;
		}
		

		return response()->json(['success' => 'Order updated successfully']);

	}

	/**
	 * updates a Single Order
	 */
	public function updateSingleOrder(){

		$order = Order::where('order_number', request()->orders)->first();

		$order->update([
			'status' => request()->status,
			'isPaid' => request()->status == 'completed' ? 1 : 0,
			'refunded_at' => request()->status == 'refunded' ? now() : null,
		]);
	}

	/**
	 * updates a Single Order
	 */
	public function updateBulkOrder(){

		$status  = request()->status;
		$orders  = collect(json_decode( request()->orders ));

		$orders->map(function($order_number) use ($status){
			// delete if it's bin
			switch ($status) {
				// move to bin
				case $status == 'trash':
				
				$this->moveToBin($order_number);

				break;

				// restore
				case $status == 'restore':
				$this->restoreOrder($order_number);

				break;

				// forceDelete
				case $status == 'delete':
				$this->deletePermanently($order_number);
				
				break;
				
				default:
				$this->saveUpdate($order_number);
				break;
			}

		});

	}

	/**
	 * empty Bin
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function emptyBin(){

		$orders = Order::onlyTrashed()->get();

		if (count($orders) > 0) {
			foreach ($orders as $order) {
				$order->products()->sync([]);
				$order->forceDelete();
			}

			return response()->json(['success' => 'Bin has been emptied.']);
		}else{

			return response()->json(['error' => 'No items found in bin!']);
		}
	}


	/**
	 * Create an order page
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function create(){

		$taxes = Tax::orderBy('tax_name', 'asc')->get();
		$order = null;

		return view('admin.orders.create', compact('taxes', 'order'));
	}

	/**
	 * Adds a product.
	 *
	 * @param      \Illuminate\Http\Request  $request  The request
	 *
	 * @return     <type>                    ( description_of_the_return_value )
	 */
	public function addProduct(Request $request){

		$validator =  Validator::make($request->all(), [
			'products' => ['required', 'array'],
			'quantity' => ['required', 'array'],
			'quantity.*' => ['numeric'],
		]);

		if ($validator->passes()) {

			$order_number =  $request->order_number;
			$products =  $request->products;
			$quantity =  $request->quantity;

			for ($i = 0; $i  < count($products); $i++) { 

				$product = Product::find($products[$i]);

				$cart = Cart::session($order_number)->add(array(
					'id' => $product->id,
					'name' =>$product->name,
					'price' => $product->price,
					'quantity' => $quantity[$i],
					'attributes' => array(),
					'associatedModel' => $product
				));
			}

			return response()->json(['success' => 'Products added']);

		}else{

			return response()->json(['error' => $validator->errors()->all()]);
		}
	}

	/**
	 * Updates product
	 *
	 * @param      \Illuminate\Http\Request  $request  The request
	 *
	 * @return     <type>                    ( description_of_the_return_value )
	 */
	public function updateProduct(Request $request){
		// return $request;
		$items = json_decode($request->items);
		$quantity = json_decode($request->quantity);
		$order_number =  $request->order_number;

		for ($i = 0; $i < count($items); $i++) { 
			Cart::session($order_number)->update($items[$i], array(
				'quantity' => array(
					'relative' => false,
					'value' => $quantity[$i]
				),
			));
		}

		return response()->json(['success' => 'product has been updated.']);
	}

	/**
	 * Removes a product.
	 *
	 * @param      \Illuminate\Http\Request  $request  The request
	 *
	 * @return     <type>                    ( description_of_the_return_value )
	 */
	public function removeProduct(Request $request){
		$order_number =  $request->order_number;
		Cart::session($order_number)->remove($request->item_id);

		return response()->json(['success' => 'Item removed from basket']);
	}

	/**
	 * Adds a tax.
	 */
	public function addTax(Request $request){

		$validator =  Validator::make($request->all(), [
			'tax' => ['required'],
		]);

		if ($validator->passes()) {

			$tax  =  Tax::find($request->tax);

			$vatCondition = new CartCondition(array(
				'name' => $tax->tax_name,
				'type' => 'tax',
			'target' => 'total', // subtotal 
			'value' => $tax->tax_percent.'%',
			'attributes' => array(
				'description' => 'Value added tax',
			)
		));

			Cart::session($request->order_number)->condition($vatCondition);

			session(['tax' => $tax->tax_name]);

			return response()->json(['success' => 'Tax applied']);

		}else{

			return response()->json(['error' => $validator->errors()->all()]);
		}
	}

	/**
	 * Removes a tax.
	 *
	 * @param      \Illuminate\Http\Request  $request  The request
	 *
	 * @return     <type>                    ( description_of_the_return_value )
	 */
	public function removeTax(Request $request){

		Cart::session($request->order_number)->removeCartCondition(session('tax'));
		session()->forget('tax');

		return response()->json(['success' => 'tax removed']);
	}



	/**
	 * Saves an order.
	 *
	 * @param      \Illuminate\Http\Request  $request  The request
	 *
	 * @return     \Illuminate\Http\Request  ( description_of_the_return_value )
	 */
	public function saveOrder(CheckoutRequest $request){

		if ($this->hasShipping()) {
			// shipping to different address

			if ($request->has('shipping_address_id')) {

				$address_id = $request->shipping_address_id;

			}else{

				$address = $this->createShippingAddress($request);
				$address_id = $address->id;
			}


		}else{

			if ($request->has('billing_address_id')) {

				$address_id = $request->billing_address_id;

			}else{

				$address = $this->createSameAddress($request);
				$address_id = $address->id;
			}
		}

		$order_number = $request->order_number;

		

		// create order
		$order = Order::create([
			'order_number' => get_order_number(),
			'order_date' => $request->order_date ?? now(),
			'user_id' => $request->customer != 'guest' ? $request->customer : null,
			'address_id' => $address_id,
			'coupon' => !empty(Cart::session($order_number)->getCondition('coupon')) ? Cart::session($order_number)->getCondition('coupon')->getAttributes()['coupon'] : null,
			'coupon_amount' => !empty(Cart::session($order_number)->getCondition('coupon')) ? getCouponValue($order_number) : null,
			'subtotal' => Cart::session($order_number)->getSubTotal(),
			'shipping_method' => null,
			'shipping_amount' => null,
			'vat' => getTaxValue(session('tax'), $order_number),
			'total_items' => Cart::session($order_number)->getTotalQuantity(),
			'grand_total' => Cart::session($order_number)->getTotal(),
			'isPaid' => 0,
			'payment_type' => $request->payment_type,
			'payment_date' => $request->order_date ?? now(),
			'payment_method' => $request->payment_method,
			'ip_address' => request()->ip(),
			'transaction_id' => $request->transaction_id ?? strtotime(now()),
		]);

		// created order items
		$products =  Cart::session($order_number)->getContent();

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

		//if action is resend order
		if ($request->has('order_actions') && $request->order_actions == 'resend_order') {

			event(new OrderPlacedEvent($order));
		}

		// clear cart
		Cart::session($order_number)->clear();
		Cart::session($order_number)->clearCartConditions();
		session()->forget('tax');

		\Session::flash('success', 'Order has been placed successfully');

		return redirect()->route('orders', ['type' => 'orders']);


	}


	public function updateStock($id, $quantity){

		$product = Product::find($id);

		$product->quantity_in_stock = $product->quantity_in_stock - $quantity;
		$product->save();
	}



	/**
	 * edits an Order
	 *
	 * @param      <type>  $slug   The slug
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function editOrder($order_number){

		$order = Order::where('order_number', $order_number)->first();
		$taxes = Tax::orderBy('tax_name', 'asc')->get();
		return view('admin.orders.edit', compact('order', 'taxes'));
	}


	/**
	 * updates an Order
	 *
	 * @param      \Illuminate\Http\Request  $request       The request
	 * @param      <type>                    $order_number  The order number
	 *
	 * @return     <type>                    ( description_of_the_return_value )
	 */
	public function saveChanges(CheckoutRequest $request, $order_number){

		$order = Order::where('order_number', $order_number)->first();

		if (!$this->isOrder()) {

			$user_id  = $request->customer;

		}else{

			$user_id  = null;
		}

		if ($this->hasShipping()) {

			$address = $this->saveShippingAddress($request, $user_id);

		}else{

			$address =  $this->saveSameAddress($request, $user_id);
		}

		$order = Order::where('order_number', $order_number)->first();

		$order->update([
			'order_date' => $request->order_date ?? now(),
			'user_id' => $user_id,
			'address_id' => $address->id,
			'status' =>  $request->status,
			'payment_type' => $request->payment_type,
			'payment_date' => $request->order_date ?? now(),
			'transaction_id' => $request->transaction_id ?? strtotime(now()),
		]);

		// if action is resend order
		if ($request->has('order_actions') && $request->order_actions == 'resend_order') {

			event(new OrderPlacedEvent($order));
		}

		\Session::flash('success', 'Order updated successfully');

		return redirect()->route('orders', ['type' => 'orders']);

	}


	/**
	 * Determines if order.
	 *
	 * @return     bool  True if order, False otherwise.
	 */
	public function isOrder(){

		return request()->customer === request()->order_number;
	}

}
