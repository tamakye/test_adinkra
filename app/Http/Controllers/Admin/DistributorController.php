<?php

namespace App\Http\Controllers\Admin;

use App\Events\ResetDistributorPassword;
use App\Http\Controllers\Controller;
use App\Http\Requests\AccountUpdateRequest;
use App\Models\Distributor;
use App\Traits\DistributorTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

class DistributorController extends Controller
{
	use DistributorTrait;

	public function index(){

		$distributors = Distributor::latest()->get();

		return view('dashboard.distributors.index', compact('distributors'));
	}

	// show create page
	public function create(){

		return view('dashboard.distributors.create');
	}

	/**
	 * Store new distributor
	 *
	 * @param      \Illuminate\Http\Request  $request  The request
	 *
	 * @return     <type>                    ( description_of_the_return_value )
	 */
	public function store(Request $request){

		$distributor = Distributor::create($request->all());

		\Session::flash('success', 'Distributor added successfully');

		return redirect()->route('admin.distributors');
	}

	// show edit distribuutr page
	public function edit($slug){

		$distributor  = Distributor::where('slug', $slug)->firstOrfail();
		$company  = $distributor->companies;
		return view('dashboard.distributors.edit', compact('distributor', 'company'));
	}

	/**
	 * CHange status
	 *
	 * @param      \Illuminate\Http\Request  $request  The request
	 * @param      <type>                    $slug     The slug
	 *
	 * @return     <type>                    ( description_of_the_return_value )
	 */
	public function toggleStatus(Request $request, $slug)
	{
		$distributor  = Distributor::where('slug', $slug)->firstOrfail();


		if ($request->dist_status == "delete") {
			$distributor->delete();
			$status = 'Delete';
			$msg = 'error';
		}else{

			$distributor->status = $request->dist_status;
			$distributor->save();
			$status = $request->dist_status == 'active' ? 'Approved' : 'Banned';
			$msg = 'success';
		}


		\Session::flash($msg , 'Distributor status: '. $status);
		return redirect()->back();
	}


	/**
	 * Update distributor
	 *
	 * @param      \Illuminate\Http\Request  $request  The request
	 * @param      <type>                    $slug     The slug
	 *
	 * @return     <type>                    ( description_of_the_return_value )
	 */
	public function update(AccountUpdateRequest $request, $slug){


		if ($this->emailExist()) {
			return back()->withInput()->withErrors(['email' => 'The email is already in used.']);
		}

		$distributor  = Distributor::where('slug', $slug)->firstOrfail();

		$distributor->update($request->all());


		if ($request->has('password')) {
			$distributor->update([
				'password' => Hash::make($distributor->email),
			]);

			$data = [
				'email' => $distributor->email,
				'password' => $distributor->email,
				'name' => $distributor->name,
			];

			event( new ResetDistributorPassword($data));
		}

		\Session::flash('success', 'Distributor updated successfully');

		return back();
		// return redirect()->route('admin.distributors');
	}

	/**
	 * Update company details
	 *
	 * @param      \Illuminate\Http\Request  $request  The request
	 * @param      <type>                    $slug     The slug
	 *
	 * @return     \Illuminate\Http\Request  ( description_of_the_return_value )
	 */
	public function profile(Request $request, $slug){

		$validator = Validator::make($request->all(), [
			'registration_number' => ['required', 'string', 'max:250'],
			'vat' => ['required', 'string', 'max:250'],
			'trading_as' => ['required', 'string', 'max:250'],
			'director_name' => ['required', 'string', 'max:250'],
			'billing_address' => ['required', 'string', 'max:250'],
			'shipping_address' => ['required', 'string', 'max:250'],
			'primay_contact' => ['required', 'string', 'max:250'],
			'secondary_contact' => ['nullable', 'string', 'max:250'],
			'business_type' => ['required', 'string', 'max:250'],
			'sales_outlet' => ['required', 'string', 'max:250'],
			'years_in_business' => ['required', 'string', 'max:250'],
			'annual_turnover' => ['nullable', 'max:250'],
			'local_currency' => ['required', 'string', 'max:3'],
			'why_interested' => ['required', 'string', 'max:1500'],
			'trading_area' => ['required', 'string'],
			'projected_percentage' => ['required', 'string', 'max:250'],
			'trade' => ['required'],
			'other_brands' => ['nullable', 'string', 'max:1500'],
			'comments' => ['nullable', 'string', 'max:1500'],
		]); 

		if ($validator->fails()) {
			return redirect()->route('admin.distributors.edit', [ $slug, '#company-details'])->withInput()->withErrors($validator->errors()->all());
		}


		$distributor  = Distributor::where('slug', $slug)->firstOrfail();
		$company  = $distributor->companies;
		
		$company->update([
			'registration_number' => $request->registration_number,
			'vat' => $request->vat,
			'trading_as' => $request->trading_as,
			'director_name' => $request->director_name,
			'billing_address' => $request->billing_address,
			'shipping_address' => $request->shipping_address,
			'primay_contact' => $request->primay_contact,
			'secondary_contact' => $request->secondary_contact,
			'business_type' => $request->business_type,
			'sales_outlet' => $request->sales_outlet,
			'years_in_business' => $request->years_in_business,
			'annual_turnover' => json_encode($request->annual_turnover),
			'local_currency' => $request->local_currency,
			'why_interested' => $request->why_interested,
			'trading_area' => $request->trading_area,
			'projected_percentage' => $request->projected_percentage,
			'trade' => json_encode($request->trade),
			'other_brands' => $request->other_brands,
			'comments' => $request->comments,
		] );

		\Session::flash('success', 'Distributor updated successfully');

		return back();

	}
}
