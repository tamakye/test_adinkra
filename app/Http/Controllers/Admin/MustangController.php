<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mustanglabel;
use Illuminate\Http\Request;

class MustangController extends Controller
{
	public function index(){

		$labels = Mustanglabel::latest()->get();

		return view('dashboard.mustang.index', compact('labels'));
	}

	/**
	 * create shipping form
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function create(){

		return view('dashboard.mustang.create');
	}


	/**
	 * Store label
	 *
	 * @param      \Illuminate\Http\Request  $request  The request
	 *
	 * @return     <type>                    ( description_of_the_return_value )
	 */
	public function store(Request $request){

		// return $request;
		$request->validate([
			'name' => ['required', 'string', 'max:255', 'unique:mustanglabels'],
			'code' => ['required', 'string', 'max:255', 'unique:mustanglabels'],
		]);	

		$label = Mustanglabel::updateOrcreate(
			[
				'code' => !empty($request->code) ? $request->code : get_mustang_code(),
			],
			[
				'name' => $request->name,
				'status' => $request->has('status') ? 1 : 0 ,
			]);

		\Session::flash('success', 'Record saved successfully');

		return redirect()->route('admin.mustang');
	}

	/**
	 * Edit a label
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function edit($slug){

		$label = Mustanglabel::where('code', $slug)->firstOrfail();

		return view('dashboard.mustang.edit', compact('label'));
	}


	public function update(Request $request, $slug){

		$request->validate([
			'name' => ['required', 'string', 'max:255'],
			'code' => ['required', 'string', 'max:255'],
		]);	

		if ($this->labelExist()) {
			return 
			redirect()
			->back()
			->withInput()
			->withErrors(['name' => 'label already added']);
		}

		$label = Mustanglabel::where('code', $slug)->firstOrfail();

		$label->update([
			'name' => $request->name,
			'status' => $request->has('status') ? 1 : 0 ,
		]);

		\Session::flash('success', 'Record saved successfully');

		return back();
	}


	/**
	 * Checks if label exist
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function labelExist(){
		return Mustanglabel::where('name', request()->name)->where('code', '!=', request()->slug)->first();
	}
}
