<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Attribute;
use App\Models\Attributevalue;
use App\Models\Carmake;
use App\Models\Carmodel;
use App\Models\Cartype;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Condition;
use App\Models\Material;
use App\Models\Mustanglabel;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends Controller
{

	public function products(){

		$products = Product::with('categories')->orderBy('created_at', 'asc')->get();
		$labels = [];
		return view('admin.products.index', compact('products', 'labels'));
	}
	
	/**
	 * Adds a product.
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function addProduct(){

		$categories = Category::where('status', 'Published')->orderBy('created_at', 'asc')->get();
		$collections = Collection::where('status', 'Published')->orderBy('created_at', 'asc')->get();
		$materials = Material::where('status', 'Published')->orderBy('created_at', 'asc')->get();
		$conditions = Condition::where('status', 'Published')->orderBy('created_at', 'asc')->get();
		// $attributes_total = Attribute::whereHas('attributevalues')->where('status', 'Published')->orderBy('created_at', 'asc')->count();

		return view('admin.products.add-product', compact('categories', 'collections', 'materials', 'conditions'));

	}


	public function fetchProductAttributes(Request $request){

		$attributes = Attribute::orderBy('created_at', 'asc')->get();

		return view('admin.products.attributes', compact('attributes'))->render();
	}

	public function fetchProductAttributeValues(Request $request){
		
		$attributes = Attributevalue::where('attribute_id', $request->id)->orderBy('created_at', 'asc')->get();

		return response()->json($attributes);
	}

	/**
	 * Saves a product.
	 *
	 * @param      \App\Http\Requests\ProductRequest  $request  The request
	 *
	 * @return     \App\Http\Requests\ProductRequest  ( description_of_the_return_value )
	 */
	public function saveProduct(ProductRequest $request){

		$sku = !empty($request->sku) ? $request->sku :  generate_sku();

		$product = Product::create([
			'name' => $request->product_name, 
			'description' => $request->product_description, 
			'sku' => $sku,
			'quantity_in_stock' => $request->quantity_in_stock,
			'price' => $request->price, 
			'retail_price' => $request->retail_price, 
			'meta_title' => $request->meta_title,
			'meta_keywords' => $request->meta_keywords,
			'meta_description' => $request->meta_description,
			'status' => $request->status,
			'collection_id' => $request->product_collection,
			'material_id' => $request->product_material,
			'poetry_in_jewelry' => $request->poetry_in_jewelry,
			'details' => $request->details,
		]);

		// generate unique slug
		$unique_no = generate_unique_no($product);

		$product->update([
			'slug' => Str::slug($product->name).'-'.$unique_no.'.html',
			'product_number' => $unique_no,
		]);

		// sync categories
		$product->conditions()->sync($request->product_conditions);

		// sync categories
		$product->categories()->sync($request->product_category);

		// create attributes
		$this->createOrSyncAttribute($product);

		// upload Thumbnail
		$this->uploadThumbnail($product);

		//Upload the inspiration image
		$this->uploadInspirationImage($product);
		
		// upload Product Images
		$this->uploadProductImages($product);

		return back()->with('success', 'Product added successfully');

	}

	public function createOrSyncAttribute($product){
		//save attributes
		$attributes = request()->has('product_attributes') ? request()->product_attributes : null;
		$values = request()->has('attributevalues') ? request()->attributevalues : null;
		$prices = request()->has('attribute_price') ? request()->attribute_price : null;

		if (!empty($attributes)) {
			$product_att = collect([]);
			for ($i = 0; $i < count($attributes); $i++) { 
				if (!empty($attributes[$i])) {
					$att = [];
					$att['attribute_id'] = $attributes[$i];
					$att['attributevalue_id'] = $values[$i];
					$att['attribute_price'] = $prices[$i];

					$product_att->push($att);
				}
			}

			$product->attributes()->sync([]);
			$product->attributes()->sync($product_att);
		}


	}

	/**
	 * Method description
	 *
	 * @param <type>
	 * @return <type>
	 */
	public function create()
	{
		return view('admin.products.create');
	}


	/**
	 * Process products csv
	 *
	 * @param <type>
	 * @return <type>
	 */
	public function processImport(Request $request)	
	{
		$request->validate([
			'csv_file' => ['required', 'file', 'max:10240'],
		]);


		if (strtolower($request->file('csv_file')->getClientOriginalExtension()) != 'csv') {
			return  back()->withInput()->withErors(['csv_file' => 'The file is not supported. Only .csv file is allowed']);
		}

		$path = $request->file('csv_file')->getRealPath();

		// get records from csv
		// $data = array_map('str_getcsv', file($path));
		
		$csv_data = [];
		$row = 1;

		if (($handle = fopen($request->file('csv_file'), "r")) !== FALSE) {
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
				$num = count($data);
				for ($i = 0; $i < $num; $i++) {
					$csv_data[$row][$i] = $data[$i];
				}
				$row++;
			}
			fclose($handle);
		}

		// check if records exceeds 1000
		if (count($csv_data) > 1001) {
			\Session::flash('info', 'CSV file contains '. (count($csv_data) - 1001). ' records. Only 1000 records can be uploaded at time');
			return back();
		}	


		return $this->process_csv($request, $csv_data);
	}


	/**
     * process the csv file
     *
     * @param      <type>  $request  The request
     *
     * @return     <type>  ( description_of_the_return_value )
     */
	public function process_csv($request, $data){

		if (count($data) > 1) {
			$csv_data = array_slice($data, 1, 5);

			$session_data =  [

				'csv_filename' => $request->file('csv_file')->getClientOriginalName(),
				'csv_data' => json_encode($data),
			];

			$request->session()->put('csv_data',  $session_data);



		}else{

			\Session::flash('info', 'No records found in CSV file');
			return back();
		}

		return view('admin.products.upload-preview', compact('csv_data', 'data'));
	}

	/**
	 * Save imported products
	 *
	 * @param <type>
	 * @return <type>
	 */
	public function saveBulkUploadPage(Request $request)
	{
		// get csv data
		$data   = $request->session()->get('csv_data');

        // file name
		$csv_filename = $data['csv_filename'];
        // all records
		$csv_data = json_decode($data['csv_data'], true);

        // declare empty array
		$new_data = [];
		$already_records = [];
		// $categoriesId = [];
		$getProductIds = [];
		$counter = 1;
		$totalProduct = Product::max('id');

		foreach ($csv_data as $key => $row) {
			// skip first row which is the header
			if ($key == 1) {
				continue;
			}

			$productId = 	++$totalProduct;
			$productArray = 	[];
			// get categories
			$categories = collect( explode(',', $row[8]));

			foreach ($categories as $category) {

				$cat = Category::select('id')->where('slug', trim($category))->first();

				if (!empty($cat)) {
					$syncIDs[] = [ 'product_id' => $productId, 'category_id' => $cat->id];

					$productArray = $syncIDs;
				}

				

			}

			// unique number
			$unique_no = str_pad($counter++, 10, mt_rand(1000000000, 9999999999), STR_PAD_LEFT);
			$slug = Str::slug($row[0]).'-'.$unique_no.'.html';
			$getProductIds[] = 	$unique_no;
			// product_image
			$product_image = explode(',', $row[7]);	
			$product_image = json_encode($product_image);
			
			$data = [
				'slug' => $slug,
				'product_id' => $unique_no,
				'product_name' => substr($row[0], 0, 250),
				'product_description' => $row[1],
				'sku' => !empty($row[2]) ? $row[2] :  generate_sku(),
				'quantity_in_stock' => $row[3],
				'price' => $row[4],
				'retail_price' => $row[5],
				'thumbnail' => $row[6],
				'product_image' => $product_image,
				'status' => $row[9],
				'carmake_id' => Carmake::firstWhere('slug', $row[10])->id,
				'carmodel_id' => !empty($row[11]) ? Carmodel::firstWhere('slug', $row[11])->id : null,
				'cartype_id' => !empty($row[12]) ? Cartype::firstWhere('slug', $row[12])->id : null,
				'meta_title' => !empty($row[13]) ? substr($row[13], 0, 120) : null,
				'meta_keywords' => !empty($row[14]) ?  substr($row[14], 0, 150) : null,
				'meta_description' => !empty($row[15]) ?  substr($row[15], 0, 250) : null,
				'created_at' => now(),
				'updated_at' => now(),
			];

			// $product->categories()->sync($categoriesId);
			// add row data to records
			$new_data[] = $data;
		}

		$insert_data  = collect($new_data);
    	// make a collection to use chunk
    	// chunk in 500
		$chunks = $insert_data->chunk(500);
    	// insert records for the chunk
		foreach ($chunks as $chunk){

			DB::table('products')->insert($chunk->toArray());
		}

		// save categories
		DB::table('product_categories')->insert($productArray);

    	// clear csv session
		$request->session()->forget('csv_data');

		\Session::flash('success', 'Products imported successfully');

		return redirect()->route('products');
	}


	/**
	 * Fetches products.
	 *
	 * @return     <type>  The products.
	 */
	public function fetchProducts(Request $request){
		
		$products = [];

		if($request->has('q')){

			$search = $request->q;

			$products = Product::select("id", "product_name")->whereLike(["product_name", "sku"], $search)->get();
		}

		return response()->json($products);

	}

	/**
	 * Uploads a thumbnail.
	 *
	 * @param      <type>  $product  The product
	 */
	public function uploadThumbnail($product){

		if (request()->has('thumbnail')) {

			if (is_file(get_product_thumbnail($product->thumbnail))) {
				unlink(get_product_thumbnail($product->thumbnail));
			}

			$file 	= request()->file('thumbnail');
			$ext 	= $file->getClientOriginalExtension();
			$name 	= Str::slug($product->name).'-'.$product->product_number.'.'.$ext;
			$save  	= $file->storeAs('public/products-thumbnails/', $name);

			$product->update([
				'thumbnail' => $name,
			]);
		}

	}



		/**
	 * Uploads an image for product inspiration.
	 *
	 * @param      <type>  $product  The product
	 */
	public function uploadInspirationImage($product){

		if (request()->has('inspiration')) {

			if (is_file(get_product_thumbnail($product->inspiration))) {
				unlink(get_product_thumbnail($product->inspiration));
			}

			$file 	= request()->file('inspiration');
			$ext 	= $file->getClientOriginalExtension();
			$name 	= Str::slug($product->name).'-'.$product->product_number.'inspiration.'.$ext;
			$save  	= $file->storeAs('public/products-inspiration/', $name);

			$product->update([
				'inspiration' => $name,
			]);
		}

	}



	/**
	 * Uploads product images.
	 * 
	 * @param      <type>  $product  The product
	 */
	public function uploadProductImages($product){

		if (request()->has('images')) {

			$image_paths = [];
			$image_no = 0;

			foreach (request()->file('images') as $file) {
				$image_no = ++$image_no;
				$extension = strtolower($file->getClientOriginalExtension());
				// $file_name = $product->product_id.'-'.$image_no.'.'.$extension;
				$file_name = Str::slug($product->name).'-'.$product->product_number.'-'.$image_no.'.'.$extension;
				$save = $file->storeAs('public/products', $file_name);

				$image_paths[] = $file_name;

			}

			$product->update([
				'product_image' => json_encode($image_paths),
			]);

		}else{
			// set as draft if no images is uploaded
			$product->update([
				'status' => 'Draft',
			]);
		}

	}


	public function moveToBin(Request $request){

		$product = Product::where('slug', $request->slug)->first();
		$product->delete();

		return response()->json(['success' => 'Product moved to bin successfully']);
	}

	/**
	 * { function_description }
	 *
	 * @param      <type>  $slug   The slug
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function editProduct($slug){

		$product = Product::with(['attributes', 'categories', 'conditions'])->where('slug', $slug)->firstOrfail();
		$categories = Category::where('status', 'Published')->orderBy('created_at', 'asc')->get();
		$collections = Collection::where('status', 'Published')->orderBy('created_at', 'asc')->get();
		$materials = Material::where('status', 'Published')->orderBy('created_at', 'asc')->get();
		$conditions = Condition::where('status', 'Published')->orderBy('created_at', 'asc')->get();
		$attributes = Attribute::where('status', 'Published')->orderBy('created_at', 'asc')->get();
		return view('admin.products.edit-product', compact('product', 'categories', 'collections', 'materials', 'conditions', 'attributes'));
	}

	/**
	 * Updates a product
	 *
	 * @param      \Illuminate\Http\Request  $request  The request
	 * @param      <type>                    $slug     The slug
	 *
	 * @return     \Illuminate\Http\Request  ( description_of_the_return_value )
	 */
	public function updateProduct(UpdateProductRequest $request, $slug){

		$product = Product::where('slug', $slug)->firstOrfail();
		
		$product->update([
			'name' => $request->product_name, 
			'description' => $request->product_description, 
			'sku' => $request->sku,
			'quantity_in_stock' => $request->quantity_in_stock,
			'price' => $request->price, 
			'retail_price' => $request->retail_price, 
			'meta_title' => $request->meta_title,
			'meta_keywords' => $request->meta_keywords,
			'meta_description' => $request->meta_description,
			'status' => $request->status,
			'collection_id' => $request->product_collection,
			'material_id' => $request->product_material,
			'poetry_in_jewelry' => $request->poetry_in_jewelry,
			'details' => $request->details,
		]);

		$product->update([
			'slug' => Str::slug($product->name).'-'.$product->product_number.'.html',
		]);

		// sync categories
		$product->conditions()->sync($request->product_conditions);

		// sync categories
		$product->categories()->sync($request->product_category);

		// create attributes
		$this->createOrSyncAttribute($product);

		// upload Thumbnail
		$this->uploadThumbnail($product);

		//Upload the inspiration image
		$this->uploadInspirationImage($product);

		$product->categories()->sync($request->product_category);

		// upload Thumbnail
		$this->uploadThumbnail($product);
		// upload images
		$this->updateProductImage($product, $request);

		// return back()->with('info', 'Product updated successfully');
		return redirect()->route('products')->with('info', 'Product updated successfully');
	}

	/**
	 * Updates the product images
	 *
	 * @param      <type>  $product  The product
	 * @param      <type>  $request  The request
	 */
	public function updateProductImage($product, $request){

		// $new_images = [];
		$image_paths = [];
		$result = [];

		// process old images if exist
		if ($request->old_images) {
			// old uploaded images before editing
			$old_images = $request->old_images;
			// already decoded images in database
			$save_images = json_decode($product->product_image);

			$existing_images = [];
			$removed_images =  [];
			// compare is submited and in db are same
			if (count($save_images) != count($old_images)) {

				foreach ($save_images as $image) {
					// check if image is removed 
					if (in_array($image, $old_images)) {
						// continue;
						$existing_images[] = $image;
					}else{
						$removed_images[] = $image;
					}
				}
				// get the unique images to reserve
				$result = array_diff($existing_images, $removed_images);

				// delete the removed images
				foreach ($removed_images as $removed) {
					unlink(get_product_images($removed));
				}
			}
		}


		if (request()->has('images')) {

			$image_no = count($result);

			foreach (request()->file('images') as $file) {
				$image_no = ++$image_no;
				$extension = strtolower($file->getClientOriginalExtension());
				$file_name = Str::slug($product->name).'-'.$product->product_number.'-'.$image_no.'.'.$extension;
				$save = $file->storeAs('public/products', $file_name);

				$image_paths[] = $file_name;

			}


		}

		// merge images
		$new_images = array_merge($image_paths, $result);

		// update if not empty
		if (count($new_images) > 0) {
			$product->update([
				'product_image' => json_encode($new_images),
				'status' => count($new_images) > 0 ? $request->status : 'Draft',

			]);
		}
	}


	public function bulkAction(Request $request){

		if ($request->status == 'protect' && empty($request->code)) {
			return back()->with('error', 'You must select a password to protect the selected products.');
		}

		$status =  $request->status;
		$products =  collect(json_decode($request->products));

		switch ($status) {

			case $status == 'protect':

			$mustang =  Mustanglabel::where('code', $request->code)->first();

			$products->map(function($id) use ($mustang){
				$product = Product::find($id);
				$product->update([
					'protected' => 1,
					'mustanglabel_id' => $mustang->id,
				]);
			});
			break;

			case $status == 'unprotect':

			$products->map(function($id){
				$product = Product::find($id);
				$product->update([
					'protected' => 0,
					'mustanglabel_id' => null,
				]);
			});
			break;

			case $status == 'publish':
			$products->map(function($id){
				$product = Product::find($id);
				$product->update([
					'status' => 'published',
				]);
			});
			break;

			case $status == 'delete':
			$products->map(function($id){
				$product = Product::find($id);
				$product->delete();
			});
			break;
			
			default:
			// draft
			$products->map(function($id){
				$product = Product::find($id);
				$product->update([
					'status' => 'draft',
				]);
			});
			break;
		}


		\Session::flash('success', 'Products updated successfully');

		return redirect()->route('products');

	}

}
