<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Attributevalue;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AttributeController extends Controller
{
	public function index(){

		$product_attributes = Attribute::withCount('attributevalues')->get();

		return view('admin.attributes.index', compact('product_attributes'));
	}


	/**
	 * Creates an attribute.
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function createAttribute(){

		return view('admin.attributes.create');
	}




	/**
	 * Saves a attribute.
	 *
	 * @param      \Illuminate\Http\Request  $request  The request
	 *
	 * @return     \Illuminate\Http\Request  ( description_of_the_return_value )
	 */
	public function saveAttribute(Request $request){
		
		$request->validate([
			'name' => ['required', 'string', 'max:255'],
			'attribute_slug' => ['nullable', 'string', 'max:255'],
			'thumbnail' => ['nullable', 'array'],
			'thumbnail.*' => ['nullable', 'image', 'mimes:jpg,png,jpeg'],
			'title' => ['required', 'array'],
			'title.*' => ['required', 'string', 'max:120'],
			'slug' => ['required', 'array'],//'unique:attributevalues'
			'slug.*' => ['required', 'string', 'max:120'],
			'colour' => ['nullable', 'array'],
			'colour.*' => ['nullable', 'string', 'max:120'],
			'status' => ['required', 'string', 'max:255'],
		]);

		if( $request->has('attribute_slug') && Attribute::whereSlug($request->attribute_slug)->exists())
		{
			return back()->withInput()->withErrors(['attribute_slug' => "Attribute slug already taken."]);
		}


		$attribute_slug =  !empty($request->attribute_slug) ? $request->attribute_slug :  Str::slug($request->name);

		$attribute = Attribute::create([
			'name' => $request->name,
			'slug' => strtolower($attribute_slug),
			'status' => $request->status,
		]);

		// get arrays
		$title = $request->title;
		$slug = $request->slug;
		$colour = $request->colour;
		$thumbnail = $request->thumbnail;

		// loop through and save
		for ($i=0; $i < count($title); $i++) {

			$get_default =  $title[$i] == $request->default ? 1 : 0;
			

			$set_slug =  !empty($slug[$i]) ? $slug[$i] :  Str::slug($title[$i]);

			$attribute_value = Attributevalue::create([
				'attribute_id' => $attribute->id,
				'title' => $title[$i],
				'slug' => strtolower($set_slug),
				'colour' => $colour[$i],
				'default' => $get_default,
			]);

			if(!empty($thumbnail[$i])){
				$this->uploadThumbnail($thumbnail[$i], $attribute_value);
			}

		}


		\Session::flash('success', 'Record saved successfully');

		// redirect if edit
		if ($request->button_type == 'edit') {

			return redirect()->route('attributes.edit', $attribute->slug);

		}else{

			return redirect()->route('attributes');

		}
	}	


	/**
	 * Uploads a thumbnail.
	 *
	 * @param      <type>  $attribute  The attribute
	 */
	public function uploadThumbnail($thumbnail, $attribute){

		if (is_file(get_attribute_thumbnail($attribute->thumbnail))) {

			unlink(get_attribute_thumbnail($attribute->thumbnail));
		}

		$file 	= $thumbnail;
		$ext 	= $file->getClientOriginalExtension();
		$name 	= Str::slug($attribute->slug).'.'.$ext;
		$save  	= $file->storeAs('public/attributes/', $name);

		$attribute->update([
			'thumbnail' => $name,
		]);

	}


	/**
	 * Edit attribute
	 *
	 * @param      <type>  $slug   The slug
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function editAttribute($slug){

		$attribute = Attribute::with('attributevalues')->where('slug', $slug)->firstOrfail();

		return view('admin.attributes.edit', compact('attribute'));
	}


	/**
	 * updates Attribute
	 *
	 * @param      \Illuminate\Http\Request  $request  The request
	 * @param      <type>                    $slug     The slug
	 *
	 * @return     <type>                    ( description_of_the_return_value )
	 */
	public function updateAttribute(Request $request, $slug){
		// return $request;
		$request->validate([
			'name' => ['required', 'string', 'max:255'],
			'attribute_slug' => ['nullable', 'string', 'max:255'],
			'thumbnail' => ['nullable', 'array'],
			'thumbnail.*' => ['nullable', 'image', 'mimes:jpg,png,jpeg'],
			'title' => ['required', 'array'],
			'title.*' => ['required', 'string', 'max:120'],
			'slug' => ['required', 'array'],
			'slug.*' => ['required', 'string', 'max:120'],
			'colour' => ['required', 'array'],
			'colour.*' => ['required', 'string', 'max:120'],
			'status' => ['required', 'string', 'max:255'],
		]);

		$attribute = Attribute::where('slug', $slug)->firstOrfail();

		if (!$this->checkAttributeName($attribute)) {

			return back()->withInput()->withErrors(['name' => 'The attribute name has already been taken.']);

		}


		if (!$this->checkAttributeSlug($attribute)) {

			return back()->withInput()->withErrors(['slug' => 'The slug has already been taken.']);

		}

		
		$attribute_slug =  !empty($request->attribute_slug) ? $request->attribute_slug :  Str::slug($request->name);
		// update attributes
		$attribute->update([
			'name' => $request->name,
			'slug' => strtolower($attribute_slug),
			'status' => $request->status,
		]);

		// update attribute values
		// get arrays
		$title = $request->title;
		$slug = $request->slug;
		$colour = $request->colour;
		$thumbnail = $request->thumbnail;
		$value_ids = $request->values;


		// drop all attributes and thumbnails thumbnails
		$att_values = $attribute->attributevalues;
		$this->dropAttributes($attribute->attributevalues, $value_ids);

		// loop through and save
		for ($i = 0; $i < count($title); $i++) {

			$get_default =  $title[$i] == $request->default ? 1 : 0;
			
			$set_slug =  !empty($slug[$i]) ? $slug[$i] :  Str::slug($title[$i]);

			// check if old attribute value ids else new
			if ( $i  < count($value_ids)) {

				$attribute_value = Attributevalue::updateOrcreate(
					[
						'id' => $value_ids[$i],
						'attribute_id' => $attribute->id,
					],
					[

						'title' => $title[$i],
						'slug' => strtolower($set_slug),
						'colour' => $colour[$i],
						'default' => $get_default,
					]
				);

			}else{

				$attribute_value = Attributevalue::create([
					'attribute_id' => $attribute->id,
					'title' => $title[$i],
					'slug' => strtolower($set_slug),
					'colour' => $colour[$i],
					'default' => $get_default,
				]);
			}


			if (!empty($thumbnail) > 0 && array_key_exists($i, $thumbnail)) {

				$this->uploadThumbnail($thumbnail[$i], $attribute_value);
			}
		}


		\Session::flash('success', 'Record saved successfully');

		// redirect if edit
		if ($request->button_type == 'edit') {

			return redirect()->route('attributes.edit', $attribute->slug);

		}else{

			return redirect()->route('attributes');

		}

	}


	/**
	 * Checks the name exist
	 *
	 * @param      <type>  $attribute  The attribute
	 *
	 * @return     bool    ( description_of_the_return_value )
	 */
	public function checkAttributeName($attribute){

		$valid = true;

		$attribute_old = Attribute::where('name', request()->name)->first();

		if ($attribute_old && $attribute->name != $attribute_old->name) {
			$valid = false;
		}

		return $valid;

	}

	/**
	 * Checks if slug exist
	 *
	 * @param      <type>  $attribute  The attribute
	 *
	 * @return     bool    ( description_of_the_return_value )
	 */
	public function checkAttributeSlug($attribute){

		$valid = true;

		$attribute_old = Attribute::where('slug', request()->slug)->first();

		if ($attribute_old && $attribute->slug != $attribute_old->slug) {
			$valid = false;
		}

		return $valid;

	}


	/**
	 * drop Attribute Thumbnails
	 *
	 * @param      <type>  $attributes  The attributes
	 */
	public function dropAttributes($attributes, $value_ids){


		foreach ($attributes as $attribute) {

			if (!in_array($attribute->id, $value_ids)) {
				if (is_file(get_attribute_thumbnail($attribute->thumbnail))) {

					unlink(get_attribute_thumbnail($attribute->thumbnail));
				}

				$attribute->delete();

			}

		}
	}

}
