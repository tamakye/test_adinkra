<?php
namespace App\Traits;

use Cart;
use Darryldecode\Cart\CartCondition;

trait VatTrait {

	/**
	 * Adds a vat.
	 */
	public function add_vat(){

		$tax = get_vat();

		if (!empty($tax)) {
			$vatCondition = new CartCondition(array(
				'name' => $tax->tax_name,
				'type' => 'tax',
			'target' => 'total', // subtotal, total 
			'value' => $tax->tax_percent.'%',
			'attributes' => array(
				'description' => 'Value added tax',
			)
		));

			Cart::session(get_cart_id())->condition($vatCondition);

		}

		return null;
	}


	/**
		 * Determines if vat.
		 *
		 * @return     bool  True if vat, False otherwise.
		 */
	public function hasVAT(){

		$tax = get_vat();

		if (!empty($tax)) {
			
			return Cart::session(get_cart_id())->getCondition($tax->tax_name);
		}

		return null;

	}

	/**
	 * Determines if condition.
	 *
	 * @param      <type>  $condition  The condition
	 *
	 * @return     bool    True if condition, False otherwise.
	 */
	public function hasCondition($condition){

		return Cart::session(get_cart_id())->getCondition($condition);
	}


	/**
	 * apply shipping fee
	 *
	 * @param      <type>  $country   The coupon
	 * @param      <type>  $shipping  The shipping
	 */
	public function apply_shipping_cost($country, $shipping){

		$shipp_apply = $this->calculate_shipping_fee($shipping);

		$shippingCondition = new CartCondition(array(
			'name' => 'shipping',
			'type' => 'shipping',
			'target' => 'total',
			'value' => '+'.$shipp_apply,
			'attributes' => array(
				'description' => $shipping->shipping_location .' to '.  $country->name,
				'shipping_location' => $shipping->shipping_location,
				'shipping_country' => $country->name,
				'shipping_region' => !empty(request()->shipping_region) ?  request()->shipping_region: '',
				'shipping_city' => !empty( request()->shipping_city) ? request()->shipping_city : '',
				'shipping_postcode' => !empty(request()->shipping_postcode) ? request()->shipping_postcode : '',
			)
		));

		Cart::session(get_cart_id())->condition($shippingCondition);
	}


	function calculate_shipping_fee($shipping){

		if($shipping->charge_type == 'percentage'){

			$total = getTotalOrderAmount();
			$percent = $shipping->shipping_fee;

			$percent_amount = ($percent / 100) * $total;

		}else{

			$percent_amount = $shipping->shipping_fee;
		}

		return $percent_amount;
	}


	/**
	 * Applies coupon
	 *
	 * @param      <type>  $coupon  The coupon
	 */
	public function apply_coupon($coupon){

		$couponCondition = new CartCondition(array(
			'name' => 'coupon',
			'type' => 'coupon',
			'target' => 'subtotal',
			'value' => '-'.$coupon->discount.'%',
			'attributes' => array(
				'coupon' => $coupon->coupon,
				'discount' => $coupon->discount,
			)
		));

		Cart::session(get_cart_id())->condition($couponCondition);
	}

	/**
	 * { function_description }
	 *
	 * @param      <type>  $coupon  The coupon
	 */
	public function apply_coupon_on_product($coupon, $productID){

		// $productID = $coupon->product_id;

		$coupon = new CartCondition(array(
			'name' => 'coupon',
			'type' => 'coupon',
			'value' => '-'.$coupon->discount.'%',
		));

		Cart::session(get_cart_id())->addItemCondition($productID, $coupon);

	}



	/**
	 * clear Condtions
	 */
	public function clearConditions(){

		Cart::session(get_cart_id())->clearCartConditions();
	}

}