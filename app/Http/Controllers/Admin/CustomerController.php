<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Distributor;
use App\Models\Order;
use App\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

	/**
	 * Fetches customers.
	 *
	 * @param      \Illuminate\Http\Request  $request  The request
	 *
	 * @return     <type>                    The customers.
	 */
	public function fetchCustomers(Request $request){

		$users = [];

		if($request->has('q')){

			$search = $request->q;

			$users = Distributor::select("id", "name")->whereLike(["email", "name", 'phone'], $search)->get();
		}

		return response()->json($users);
	}

	/**
	 * Loads a customer.
	 *
	 * @param      \Illuminate\Http\Request  $request  The request
	 *
	 * @return     <type>                    ( description_of_the_return_value )
	 */
	public function loadCustomer(Request $request){

		$address = [];

		// if the request is an authenticated user order
		if ($request->status == 'user') {
			$distributor = Distributor::find($request->customer);

			$address = $distributor->addresses()->where(['distributor_id' => $distributor->id, 'default' => 1])->first();
		}else{

			// if the request is a guest distributor order
			$order = Order::where('order_number', $request->customer)->first();

			$address = $order->addresses()->where(['default' => 1])->first();

		}
		

		if (!empty($address)) {

			switch ($request) {
				case $request->address_type == 'shipping':
				$address_data = [
					'shipping_first_name' =>  $address->billing_first_name,
					'shipping_last_name' =>  $address->billing_last_name,
					'shipping_company' =>  $address->billing_company,
					'shipping_country' =>  $address->billing_country,
					'shipping_street_address' =>  $address->billing_street_address,
					'shipping_optional_street_address' =>  $address->billing_optional_street_address,
					'shipping_city' =>  $address->billing_city,
					'shipping_county' =>  $address->billing_county,
					'shipping_postcode' =>  $address->billing_postcode,
					'shipping_phone' =>  $address->billing_phone,
					'shipping_email' =>  $address->billing_email,
					'shipping_vat' =>  $address->billing_vat,
				];
				break;
				
				default:
				$address_data = [
					'billing_first_name' =>  $address->billing_first_name,
					'billing_last_name' =>  $address->billing_last_name,
					'billing_company' =>  $address->billing_company,
					'billing_country' =>  $address->billing_country,
					'billing_street_address' =>  $address->billing_street_address,
					'billing_optional_street_address' =>  $address->billing_optional_street_address,
					'billing_city' =>  $address->billing_city,
					'billing_county' =>  $address->billing_county,
					'billing_postcode' =>  $address->billing_postcode,
					'billing_phone' =>  $address->billing_phone,
					'billing_email' =>  $address->billing_email,
					'billing_vat' =>  $address->billing_vat,
				];
				break;
			}

		}else{
			$address_data = [
				'billing_first_name' => 	$distributor->name,
				// 'billing_last_name' => 	$distributor->last_name,
				'billing_email' => 	$distributor->email,
				'billing_phone' => 	$distributor->phone,
			];
		}
		return response()->json($address_data);
	}
}
