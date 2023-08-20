<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
	public function index(){

		$categories = Category::withCount(['products'])->get();
		$collections = Collection::all();

		return view('admin.categories.index', compact('categories', 'collections'));
	}


	public function saveCategory(Request $request){

		$request->validate([
			'name' => ['required', 'string', 'max:250', 'unique:categories'],
			'slug' => ['nullable', 'string', 'max:250', 'unique:categories'],
			'description' => ['nullable', 'string', 'max:500'],
			'collection' => ['required', 'integer'],
			'status' => ['required', 'string'],
			// 'parent_category' => ['required'],
			'thumbnail' => ['nullable', 'image', 'mimes:jpg,png,jpeg'],
		]);


		$slug =  !empty($request->slug) ? $request->slug :  Str::slug($request->name);
		// $parent_category =  $request->parent_category != 'none' ? $request->parent_category : null;

		$category = Category::create([
			'name' =>  $request->name,
			'slug' =>  strtolower($slug),
			'description' =>  $request->description,
			'status' =>  $request->status,
			'collection_id' =>  $request->collection,

		]);

		$this->uploadThumbnail($category);

		\Session::flash('success', 'Category saved successfully');

		return back();
	}


	/**
	 * Uploads a thumbnail.
	 *
	 * @param      <type>  $category  The category
	 */
	public function uploadThumbnail($category){

		if (request()->has('thumbnail')) {

			if (is_file(get_category_thumbnail($category->thumbnail))) {
				unlink(get_category_thumbnail($category->thumbnail));
			}

			$file 	= request()->file('thumbnail');
			$ext 	= $file->getClientOriginalExtension();
			$name 	= Str::slug($category->slug).'.'.$ext;
			$save  	= $file->storeAs('public/categories/', $name);

			$category->update([
				'thumbnail' => $name,
			]);
		}

	}

	/**
	 * Edit category
	 *
	 * @param      <type>  $slug   The slug
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function editCategory($slug){

		$category = Category::where('slug', $slug)->firstOrfail();
		$categories = Category::all();

		return view('admin.categories.edit-category',compact('category', 'categories'));
	}

	/**
	 * updates Category
	 *
	 * @param      \Illuminate\Http\Request  $request  The request
	 * @param      <type>                    $slug     The slug
	 *
	 * @return     <type>                    ( description_of_the_return_value )
	 */
	public function updateCategory(Request $request, $slug){

		$request->validate([
			'name' => ['required', 'string', 'max:250',],
			'slug' => ['nullable', 'string', 'max:250',],
			'description' => ['nullable', 'string', 'max:500'],
			// 'parent_category' => ['required'],
			'thumbnail' => ['nullable', 'image', 'mimes:jpg,png,jpeg'],
		]);


		$category = Category::where('slug', $slug)->firstOrfail();

		if (!$this->checkCategoryName($category)) {

			return back()->withInput()->withErrors(['name' => 'The name has already been taken.']);

		}


		if (!$this->checkCategorySlug($category)) {

			return back()->withInput()->withErrors(['slug' => 'The slug has already been taken.']);

		}

		$new_slug =  !empty($request->slug) ? $request->slug :  Str::slug($request->name);
		$parent_category =  $request->parent_category != 'none' ? $request->parent_category : null;


		$category = $category->update([
			'name' =>  $request->name,
			'slug' =>  strtolower($slug),
			'description' =>  $request->description,
			'status' =>  $request->status,
			'category_id' =>  $parent_category,
		]);

		$this->uploadThumbnail($category);

		\Session::flash('success', 'Record saved successfully');

		return redirect()->route('categories');
	}


	/**
	 * Checks the name exist
	 *
	 * @param      <type>  $category  The category
	 *
	 * @return     bool    ( description_of_the_return_value )
	 */
	public function checkCategoryName($category){

		$valid = true;

		$category_old = Category::where('name', request()->name)->first();

		if ($category_old && $category->name != $category_old->name) {
			$valid = false;
		}

		return $valid;

	}

	/**
	 * Checks if slug exist
	 *
	 * @param      <type>  $category  The category
	 *
	 * @return     bool    ( description_of_the_return_value )
	 */
	public function checkCategorySlug($category){

		$valid = true;

		$category_old = Category::where('slug', request()->slug)->first();

		if ($category_old && $category->slug != $category_old->slug) {
			$valid = false;
		}

		return $valid;

	}	


	public function fetchCategory(Request $request){
		
		$categories = Category::where('collection_id', $request->id)->orderBy('name', 'asc')->get();

		return response()->json($categories);
	}

}
