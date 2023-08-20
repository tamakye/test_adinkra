<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shipping;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
	public function index(){

		$shippings = Shipping::with('countries')->latest()->get();

		return view('admin.shippings.index', compact('shippings'));
	}

	/**
	 * Fetches countries.
	 *
	 * @param      \Illuminate\Http\Request  $request  The request
	 *
	 * @return     <type>                    The countries.
	 */
	public function fetchCountries(Request $request){

		$shipping = Shipping::find($request->id);

		return view('admin.shippings.modal-content-data', compact('shipping'))->render();
	}


	/**
	 * create shipping form
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function create(){

		return view('admin.shippings.create');
	}


	/**
	 * Store shipping
	 *
	 * @param      \Illuminate\Http\Request  $request  The request
	 *
	 * @return     <type>                    ( description_of_the_return_value )
	 */
	public function store(Request $request){

		$request->validate([
			'shipping_location' => ['required', 'string', 'max:255', 'unique:shippings'],
			'shipping_fee' => ['required', 'min:0'],
			'charge_type' => ['required', 'string'],
			'shipping_countries' => ['required'],
		]);	

		$shipping = Shipping::create([
			'slug' => strtotime(now()),
			'shipping_location' => $request->shipping_location,
			'charge_type' => $request->charge_type,
			'shipping_fee' => $request->shipping_fee,
		]);

		// return $request;

		if(!in_array('worldwide', $request->shipping_countries)){
			$shipping->countries()->sync($request->shipping_countries);
		}


		\Session::flash('success', 'Record saved successfully');

		return redirect()->route('admin.shipping');
	}


	/**
	 * Show edit page for shipping
	 *
	 * @param      <type>  $slug   The slug
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function edit($slug){

		$shipping = Shipping::where('slug', $slug)->firstOrfail();

		return view('admin.shippings.edit', compact('shipping'));
	}


	public function update(Request $request, $slug){

		$request->validate([
			'shipping_location' => ['required', 'string', 'max:255'],
			'shipping_fee' => ['required', 'min:0'],
			'charge_type' => ['required', 'string'],
			'shipping_countries' => ['required'],
		]);	


		$shipping = Shipping::where('slug', $slug)->firstOrfail();

		if (!$this->nameExist($shipping)) {
			
			return 
			redirect()
			->back()
			->withInput()
			->withErrors(['shipping_location' => 'shipping location already exist']);
		}


		$shipping->update([
			'shipping_location' => $request->shipping_location,
			'charge_type' => $request->charge_type,
			'shipping_fee' => $request->shipping_fee,
		]);

		$shipping->countries()->sync($request->shipping_countries);

		\Session::flash('success', 'Record saved successfully');

		return redirect()->route('admin.shipping');
	}


	/**
	 * shipping location exist
	 *
	 * @param      <type>  $shipping  The shipping
	 *
	 * @return     bool    ( description_of_the_return_value )
	 */
	public function nameExist($shipping){

		$valid = true;

		$shiping_old = Shipping::where('shipping_location', request()->shipping_location)->first();

		if ($shiping_old && $shipping->shipping_location != $shiping_old->shipping_location) {
			$valid = false;
		}

		return $valid;
	}



}
