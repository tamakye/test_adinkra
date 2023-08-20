<?php

use App\Models\Country;
use App\Models\Region;
use App\Models\Tax;
use App\Models\Wishlist;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

/**
 * Gets the cartesian identifier.
 *
 * @return     <type>  The cartesian identifier.
 */
function get_cart_id(){
	return \Request::ip().'_'.request()->header('User-Agent');
    // return request()->getSession()->getId();
}

function set_wishlist_id(){

   return $records = Auth::check() ? Auth::user()->slug : \Request::ip().'_'.request()->header('User-Agent');
    // return Crypt::encryptString($records);
}

function get_wishlist_id(){

    return $records = Auth::check() ? Auth::user()->slug : \Request::ip().'_'.request()->header('User-Agent');

    // try {
    //     $decrypted = Crypt::decryptString($records);
    // } catch (DecryptException $e) {
    //     $decrypted = null;
    // }

    // return $decrypted;

}

function userHasWishlist(){

    return Wishlist::wishlistExist();
}

/**
 * Determines whether the specified item identifier is item.
 *
 * @param      <type>  $itemId  The item identifier
 *
 * @return     bool    True if the specified item identifier is item, False otherwise.
 */
function isItem($itemId){
	return Cart::session(get_cart_id())->get($itemId);
}


/**
 * Gets the vat.
 *
 * @return     <type>  The vat.
 */
function get_vat(){

	return  Tax::where('tax_name', 'VAT')->first();
    // return  Tax::find(1);

}


/**
 * Gets the vat value.
 *
 * @return     <type>  The vat value.
 */
function getVatValue(){

	$tax = get_vat();

    if(empty($tax)){
        return 0.00;
    }
	
	return getConditionValue($tax->tax_name);
}

/**
 * Gets the shipping value.
 *
 * @return     <type>  The shipping value.
 */
function getShippingValue(){

	return getConditionValue('shipping');
}


/**
 * Gets the shipping condtion.
 *
 * @return     <type>  The shipping condtion.
 */
function getShippingCondition(){

	return Cart::session(get_cart_id())->getCondition('shipping');
}

/**
 * Gets the condition value.
 *
 * @param      <type>  $condition_name  The condition name
 *
 * @return     int     The condition value.
 */
function getConditionValue($condition_name, $session = null){
    $session_id = !empty($session) ? $session : get_cart_id();
    $calculatedValue = 0;
    $condition = Cart::session($session_id)->getCondition($condition_name);

    if (!empty($condition)) {


      $subTotal = Cart::session(get_cart_id())->getSubTotal();

      $calculatedValue = $condition->getCalculatedValue($subTotal);

  }

  return $calculatedValue;
}

/**
 * Gets the coupon condition.
 *
 * @return     <type>  The coupon condition.
 */
function getCouponCondition(){

	return Cart::session(get_cart_id())->getCondition('coupon');
}


/**
 * Gets the coupon value.
 *
 * @return     <type>  The coupon value.
 */
function getCouponValue(){

	return getConditionValue('coupon');
}

/**
 * Gets the sub total amount
 *
 * @return     <type>  ( description_of_the_return_value )
 */
function getsubTotalAmount(){

	return Cart::session(get_cart_id())->getSubTotalWithoutConditions(); 
}


/**
 * Gets the total order amount.
 *
 * @return     <type>  The total order amount.
 */
function getTotalOrderAmount(){

	return Cart::session(get_cart_id())->getTotal(); 
}

/**
 * Gets the cartesian quantity.
 *
 * @return     <type>  The cartesian quantity.
 */
function getCartQuantity(){

	return Cart::session(get_cart_id())->getTotalQuantity();
}


/**
 * Gets the order date.
 *
 * @param      <type>  $order  The order
 *
 * @return     <type>  The order date.
 */
function get_order_date($order){
	return Carbon::parse($order->order_date)->format('dS M, Y');
}


/**
 * Gets the custom local time.
 *
 * @param      <type>  $date   The date
 *
 * @return     <type>  The custom local time.
 */
function getCustomLocalTime($date){

	$newDateTime = date('g:i A', strtotime($date));

	$new_date =  $date->format('dS M, Y') .' at '. $newDateTime;

	return $new_date;
}



/**
 * Gets the country.
 *
 * @return     <type>  The country.
 */
function get_country(){

	return !empty(getShippingCondition()) ? getShippingCondition()->getAttributes()['shipping_country'] : 'Ghana';
}
/**
 * Gets the country region.
 *
 * @param      <type>  $country  The country
 *
 * @return     <type>  The country region.
 */
function get_country_region(){

	$country = Country::where('name', get_country())->first();

	$region = Region::where('country_id', $country->id)->get();

	return $region;

}


/**
 * shipping arr
 *
 * @param      array  $shipping  The shipping
 */
function shipping_arr($shipping){
	$shipping_ids = [];

	if (count($shipping->countries) > 0) {
		
		foreach ($shipping->countries as $country) {
			$shipping_ids[] = $country->id;
		}
	}

	return $shipping_ids;
}
