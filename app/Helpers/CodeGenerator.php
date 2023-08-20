<?php

use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;

/**
 * Gets the coupon.
 *
 * @return     <type>  The coupon.
 */
function get_coupon(){

	do {
		$str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'; 

		$result  = substr(str_shuffle($str_result), 0, 7); 

	} while ( Coupon::where('coupon', $result)->first());

	return 	$result;
}


/**
 * Gets the order number.
 *
 * @return     <type>  The order number.
 */
function get_order_number(){

	// $get_number = session('order_number');
	
	// if (empty($get_number) ) {


	// 	$order = Order::count();
	// 	$order_number = ++$order;

	// 	session(['order_number' => $order_number]);

	// }else{

	// 	$order_number = ++$get_number;
	// 	session()->forget('order_number');
	// 	session(['order_number' => $order_number]);
	// }
	

	$order = Order::count();
	$order_number = ++$order;

	return str_pad($order_number, 5, 0 , STR_PAD_LEFT);
	// return str_pad($order->id, 5, 0 , STR_PAD_LEFT);
}

/**
 * generates a unique no
 *
 * @param      <type>  $model  The model
 *
 * @return     <type>  ( description_of_the_return_value )
 */
function generate_unique_no($model){

	return str_pad($model->id, 10, mt_rand(1000000000, 9999999999), STR_PAD_LEFT);
}


/**
 * generates sku
 *
 * @return     <type>  ( description_of_the_return_value )
 */
function generate_sku(){

	do {

		$str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; 
		$result  = substr(str_shuffle($str_result), 0, 12); 

	} while (Product::where('sku', $result)->first());

	return $result;


}

/**
 * Gets the mustang code.
 *
 * @return     <type>  The mustang code.
 */
function get_mustang_code(){

	$str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'; 

	$result  = substr(str_shuffle($str_result), 0, 7); 

	return 	$result;
}
