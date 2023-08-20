<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tax;
use Illuminate\Http\Request;

class TaxController extends Controller
{
	public function index(){

		$taxes = Tax::latest()->get();

		return view('admin.taxes.index', compact('taxes'));
	}

	/**
	 * create shipping form
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function create(){

		return view('admin.taxes.create');
	}


	/**
	 * Store tax
	 *
	 * @param      \Illuminate\Http\Request  $request  The request
	 *
	 * @return     <type>                    ( description_of_the_return_value )
	 */
	public function store(Request $request){

		$request->validate([
			'tax_name' => ['required', 'string', 'max:255'],
			'rate' => ['required', 'min:0.1'],
		]);	

		if ($this->taxExist()) {
			return 
			redirect()
			->back()
			->withInput()
			->withErrors(['tax_name' => 'Tax already added']);
		}

		$tax = Tax::updateOrcreate(
			[
				'tax_code' => $request->has('tax_code') ? $request->tax_code : mt_rand(),
			],
			[
				'tax_name' => $request->tax_name,
				'tax_percent' => $request->rate,
				'tax_class' => 'Standard',
			]);

		\Session::flash('success', 'Record saved successfully');

		return redirect()->route('admin.taxes');
	}

	/**
	 * Edit a tax
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function edit($slug){

		$tax = Tax::where('tax_code', $slug)->firstOrfail();

		return view('admin.taxes.edit', compact('tax'));
	}


	/**
	 * Checks if tax exist
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function taxExist(){
		return Tax::where(['tax_name' => request()->tax_name, 'tax_percent' => request()->rate])->first();
	}
}
