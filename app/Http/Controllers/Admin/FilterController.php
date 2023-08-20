<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\Condition;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FilterController extends Controller
{

	// public function index(){

	// 	return view('admin.filters.index');
	// }

	// ================================== Collections ===========================
	/**
	 * Show list of collection 
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function showCollections(){

		$collections = Collection::get();
		// $collections = Collection::withCount('products')->get();

		return view('admin.collections.index', compact('collections'));
	}


	/**
	 * Saves a collections.
	 *
	 * @param      \Illuminate\Http\Request  $request  The request
	 *
	 * @return     \Illuminate\Http\Request  ( description_of_the_return_value )
	 */
	public function saveCollections(Request $request){

		$request->validate([
			'name' => ['required', 'string', 'max:250', 'unique:collections'],
			'slug' => ['nullable', 'string', 'max:250', 'unique:collections'],
			'description' => ['required', 'string', 'max:500'],
			'status' => ['required', 'string'],
			'thumbnail' => ['required', 'image', 'mimes:jpg,png,jpeg'],
		]);

		$slug =  !empty($request->slug) ? $request->slug :  Str::slug($request->name);

		$collection = Collection::create([
			'name' =>  $request->name,
			'slug' =>  strtolower($slug),
			'description' =>  $request->description,
			'status' =>  $request->status,
		]);

		$this->uploadThumbnail($collection);

		\Session::flash('success', 'Record saved successfully');

		return back();
	}

	/**
	 * Uploads a thumbnail.
	 *
	 * @param      <type>  $collection  The collection
	 */
	public function uploadThumbnail($collection){

		if (request()->has('thumbnail')) {

			if (is_file(get_collection_thumbnail($collection->thumbnail))) {
				unlink(get_collection_thumbnail($collection->thumbnail));
			}

			$file 	= request()->file('thumbnail');
			$ext 	= $file->getClientOriginalExtension();
			$name 	= Str::slug($collection->slug).'-'.strtotime(now()).'.'.$ext;
			$save  	= $file->storeAs('public/filters/', $name);

			$collection->update([
				'thumbnail' => $name,
			]);
		}

	}


	/**
	 * Edit the collections
	 *
	 * @param      <type>  $slug   The slug
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function editCollections($slug){

		$collection = Collection::where('slug', $slug)->firstOrfail();

		return view('admin.collections.edit-collections',compact('collection'));
	}	


	public function updateCollections(Request $request, $slug){

		$request->validate([
			'name' => ['required', 'string', 'max:250'],
			'slug' => ['nullable', 'string', 'max:250'],
			'description' => ['required', 'string', 'max:500'],
			'status' => ['required', 'string'],
			'thumbnail' => ['nullable', 'image', 'mimes:jpg,png,jpeg'],
		]);


		$collection = Collection::where('slug', $slug)->firstOrfail();

		if (!$this->checkCollectionName($collection)) {

			return back()->withInput()->withErrors(['name' => 'The name has already been taken.']);

		}


		if (!$this->checkCollectionSlug($collection)) {

			return back()->withInput()->withErrors(['slug' => 'The slug has already been taken.']);

		}

		$new_slug =  !empty($request->slug) ? $request->slug :  Str::slug($request->name);

		$collection->update([
			'name' =>  $request->name,
			'slug' =>  strtolower($new_slug),
			'description' =>  $request->description,
			'status' =>  $request->status,
		]);

		$this->uploadThumbnail($collection);

		return to_route('collections')->with('success', 'Record saved successfully');
	}


	/**
	 * Checks the name exist
	 *
	 * @param      <type>  $collection  The collection
	 *
	 * @return     bool    ( description_of_the_return_value )
	 */
	public function checkCollectionName($collection){

		$valid = true;

		$checkcollection = Collection::where('name', request()->name)->first();

		if ($checkcollection && $collection->name != $checkcollection->name) {
			$valid = false;
		}

		return $valid;

	}

	/**
	 * Checks if slug exist
	 *
	 * @param      <type>  $collection  The collection
	 *
	 * @return     bool    ( description_of_the_return_value )
	 */
	public function checkCollectionSlug($collection){

		$valid = true;

		$checkcollection = Collection::where('slug', request()->slug)->first();

		if ($checkcollection && $collection->slug != $checkcollection->slug) {
			$valid = false;
		}

		return $valid;

	}
	

	// ================================== materials ===========================

	public function showMaterials(){

		$materials = Material::get();
			// $materials = Material::withCount('products')->get();

		return view('admin.materials.index', compact('materials'));
	}


	public function saveMaterials(Request $request){

		$request->validate([
			'name' => ['required', 'string', 'max:250', 'unique:materials'],
			'slug' => ['nullable', 'string', 'max:250', 'unique:materials'],
			'description' => ['required', 'string', 'max:500'],
			'status' => ['required', 'string'],
			// 'thumbnail' => ['required', 'image', 'mimes:jpg,png,jpeg'],
		]);

		$slug =  !empty($request->slug) ? $request->slug :  Str::slug($request->name);

		$material = material::create([
			'name' =>  $request->name,
			'slug' =>  strtolower($slug),
			'description' =>  $request->description,
			'status' =>  $request->status,
		]);

		return back()->with('success', 'Record saved successfully');
	}


	public function editMaterials($slug){

		$material = Material::where('slug', $slug)->firstOrfail();

		return view('admin.materials.edit-materials',compact('material'));
	}	


	public function updateMaterials(Request $request, $slug){

		$request->validate([
			'name' => ['required', 'string', 'max:250'],
			'slug' => ['nullable', 'string', 'max:250'],
			'description' => ['required', 'string', 'max:500'],
			'status' => ['required', 'string'],
			// 'thumbnail' => ['nullable', 'image', 'mimes:jpg,png,jpeg'],
		]);


		$material = Material::where('slug', $slug)->firstOrfail();

		if (!$this->checkMaterialName($material)) {

			return back()->withInput()->withErrors(['name' => 'The name has already been taken.']);

		}


		if (!$this->checkMaterialSlug($material)) {

			return back()->withInput()->withErrors(['slug' => 'The slug has already been taken.']);

		}

		$new_slug =  !empty($request->slug) ? $request->slug :  Str::slug($request->name);

		$material->update([
			'name' =>  $request->name,
			'slug' =>  strtolower($new_slug),
			'description' =>  $request->description,
			'status' =>  $request->status,
		]);

		return to_route('materials')->with('success', 'Record saved successfully');
	}

	public function checkMaterialName($material){

		$valid = true;

		$checkmaterial = Material::where('name', request()->name)->first();

		if ($checkmaterial && $material->name != $checkmaterial->name) {
			$valid = false;
		}

		return $valid;

	}

	/**
	 * Checks if slug exist
	 *
	 * @param      <type>  $collection  The collection
	 *
	 * @return     bool    ( description_of_the_return_value )
	 */
	public function checkMaterialSlug($material){

		$valid = true;

		$checkmaterial = Material::where('slug', request()->slug)->first();

		if ($checkmaterial && $material->slug != $checkmaterial->slug) {
			$valid = false;
		}

		return $valid;

	}



	// ================================== conditions ===========================

	public function showConditions(){

		$conditions = Condition::get();
		// $conditions = Condition::withCount('products')->get();

		return view('admin.conditions.index', compact('conditions'));
	}


	public function saveConditions(Request $request){

		$request->validate([
			'name' => ['required', 'string', 'max:250', 'unique:conditions'],
			'slug' => ['nullable', 'string', 'max:250', 'unique:conditions'],
			'description' => ['required', 'string', 'max:500'],
			'status' => ['required', 'string'],
			// 'thumbnail' => ['required', 'image', 'mimes:jpg,png,jpeg'],
		]);

		$slug =  !empty($request->slug) ? $request->slug :  Str::slug($request->name);

		$collection = Condition::create([
			'name' =>  $request->name,
			'slug' =>  strtolower($slug),
			'description' =>  $request->description,
			'status' =>  $request->status,
		]);

		return back()->with('success', 'Record saved successfully');
	}



	public function editConditions($slug){

		$condition = Condition::where('slug', $slug)->firstOrfail();

		return view('admin.conditions.edit-conditions',compact('condition'));
	}	


	public function updateConditions(Request $request, $slug){

		$request->validate([
			'name' => ['required', 'string', 'max:250'],
			'slug' => ['nullable', 'string', 'max:250'],
			'description' => ['required', 'string', 'max:500'],
			'status' => ['required', 'string'],
			'thumbnail' => ['nullable', 'image', 'mimes:jpg,png,jpeg'],
		]);


		$condition = Condition::where('slug', $slug)->firstOrfail();

		if (!$this->checkCondtionName($condition)) {

			return back()->withInput()->withErrors(['name' => 'The name has already been taken.']);

		}


		if (!$this->checkCoditionSlug($condition)) {

			return back()->withInput()->withErrors(['slug' => 'The slug has already been taken.']);

		}

		$new_slug =  !empty($request->slug) ? $request->slug :  Str::slug($request->name);

		$condition->update([
			'name' =>  $request->name,
			'slug' =>  strtolower($new_slug),
			'description' =>  $request->description,
			'status' =>  $request->status,
		]);

		return to_route('conditions')->with('success', 'Record saved successfully');
	}


	public function checkCondtionName($condition){

		$valid = true;

		$checkcondition = Condition::where('name', request()->name)->first();

		if ($checkcondition && $condition->name != $checkcondition->name) {
			$valid = false;
		}

		return $valid;

	}

	public function checkCoditionSlug($condition){

		$valid = true;

		$checkcondition = Condition::where('slug', request()->slug)->first();

		if ($checkcondition && $condition->slug != $checkcondition->slug) {
			$valid = false;
		}

		return $valid;

	}


	/**
	 * Fetches car models.
	 *
	 * @param      \Illuminate\Http\Request  $request  The request
	 *
	 * @return     <type>                    The car models.
	 */
	public function fetchCarModels(Request $request){

		$models = Carmodel::where('carmake_id', $request->id)->get();

		return response()->json($models);
	}

	/**
	 * Fetches car model types.
	 *
	 * @param      \Illuminate\Http\Request  $request  The request
	 *
	 * @return     <type>                    The car model types.
	 */
	public function fetchCarModelTypes(Request $request){

		$models = Cartype::where('carmodel_id', $request->id)->get();

		return response()->json($models);
	}

}
