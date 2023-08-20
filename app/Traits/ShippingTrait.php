<?php

namespace App\Traits;

use App\Models\Address;
use App\Models\Distributor;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

trait ShippingTrait{


	/**
	 * Determines if shipping.
	 *
	 * @return     bool  True if shipping, False otherwise.
	 */
	private function hasShipping(){

		return !empty(request()->shipping_first_name) && !empty(request()->shipping_last_name);
	}



	/**
	 * Creates a shipping address.
	 *
	 * @param      <type>  $request  The request
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function createShippingAddress($request){

		if ($request->has('customer') && $request->customer != 'guest') {
			$user_id = $request->customer;

		}elseif(Auth::check()){

			$user = Auth::user();

			if ($user ) {
				$user_id = $user->id;
			}else{
				$user_id = null;
			}


		}else{

			$user_id = null;
		}


		$this->unsetDefaultAddress($user_id);

		return $this->saveShippingAddress($request, $user_id);
	}



	/**
	 * Saves a shipping address.
	 *
	 * @param      <type>  $request  The request
	 * @param      string  $user_id  The distributor identifier
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function saveShippingAddress($request, $user_id = ''){

		return Address::updateOrcreate(
			[
				'slug' => !empty($request->address_slug) ? $request->address_slug : strtotime(now()),
			],
			[
				'user_id' =>  $user_id,
				'default' => 1,
				'billing_first_name' =>  $request->billing_first_name,
				'billing_last_name' =>  $request->billing_last_name,
				'billing_address_one' =>  $request->billing_address_one,
				'billing_address_two' =>  $request->billing_address_two,
				'billing_country' =>  $request->billing_country,
				'billing_region' =>  $request->billing_region,
				'billing_city' =>  $request->billing_city,
				'billing_zip_code' =>  $request->billing_zip_code,
				'billing_phone' =>  $request->billing_phone,
				'billing_email' =>  $request->billing_email,
				'billing_vat' =>  $request->billing_vat,

				'shipping_first_name' =>  $request->shipping_first_name,
				'shipping_last_name' =>  $request->shipping_last_name,
				'shipping_address_one' =>  $request->shipping_address_one,
				'shipping_address_two' =>  $request->shipping_address_two,
				'shipping_country' =>  $request->shipping_country,
				'shipping_region' =>  $request->shipping_region,
				'shipping_city' =>  $request->shipping_city,
				'shipping_zip_code' =>  $request->shipping_zip_code,
				'shipping_phone' =>  $request->shipping_phone,
				'shipping_email' =>  $request->shipping_email,
				'shipping_vat' =>  $request->shipping_vat,

				'order_notes' =>  $request->order_notes,
			]

		);
	}


	/**
	 * Creates a same address.
	 *
	 * @param      <type>  $request  The request
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function createSameAddress($request){

		if ($request->has('customer') && $request->customer != 'guest') {
			$user_id = $request->customer;

		}elseif(Auth::check()){

			$user = Auth::user();

			if ($user ) {
				$user_id = $user->id;
			}else{
				$user_id = null;
			}


		}else{

			$user_id = null;
		}

		$this->unsetDefaultAddress($user_id);
		
		return $this->saveSameAddress($request, $user_id);
	}


	/**
	 * Saves a same address.
	 *
	 * @param      <type>  $request  The request
	 * @param      <type>  $user_id  The distributor identifier
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function saveSameAddress($request, $user_id = ''){


		return Address::updateOrcreate(
			[
				'slug' => !empty($request->slug) ? $request->slug : strtotime(now()),
			],
			[
				'user_id' => $user_id,
				'default' => 1,

				'billing_first_name' =>  $request->billing_first_name,
				'billing_last_name' =>  $request->billing_last_name,
				'billing_address_one' =>  $request->billing_address_one,
				'billing_address_two' =>  $request->billing_address_two,
				'billing_country' =>  $request->billing_country,
				'billing_region' =>  $request->billing_region,
				'billing_city' =>  $request->billing_city,
				'billing_zip_code' =>  $request->billing_zip_code,
				'billing_phone' =>  $request->billing_phone,
				'billing_email' =>  $request->billing_email,
				'billing_vat' =>  $request->billing_vat,

				'shipping_first_name' =>  $request->billing_first_name,
				'shipping_last_name' =>  $request->billing_last_name,
				'shipping_address_one' =>  $request->billing_address_one,
				'shipping_address_two' =>  $request->billing_address_two,
				'shipping_country' =>  $request->billing_country,
				'shipping_region' =>  $request->billing_region,
				'shipping_city' =>  $request->billing_city,
				'shipping_zip_code' =>  $request->billing_zip_code,
				'shipping_phone' =>  $request->billing_phone,
				'shipping_email' =>  $request->billing_email,
				'shipping_vat' =>  $request->billing_vat,

				'order_notes' =>  $request->order_notes,
			]
		);
	}

	public function unsetDefaultAddress($user_id)
	{

		if(Address::where('user_id', $user_id)->count() > 0){
			Address::where('user_id', $user_id)->update(['default' => 0]);
		}

		// $address = Address::where(['user_id' => Auth::id(), 'default' => 1])->first();

		// if (!empty($address)) {
		// 	$address->default = 0;
		// 	$address->save();
		// }
		
	}
}