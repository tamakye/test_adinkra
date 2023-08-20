<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Collection;
use App\Models\Contact;
use App\Models\Country;
use App\Models\Customjewelry;
use App\Models\Material;
use App\Models\Product;
use App\Models\Region;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function welcome(){

        $initialCount = 6;

        $products = Product::whereHas('collections', function($query){
            $query->where('name', 'ADINKRA JEWELRY');
        })->withCount('attributes')->where('status', 'Published')
        ->limit($initialCount)
        ->inRandomOrder()
        ->get();

        $legacyProducts = Product::whereHas('collections', function($query){
            $query->where('name', 'LEGACY JEWELRY');
        })->withCount('attributes')->where('status', 'Published')
        ->limit($initialCount)
        ->inRandomOrder()
        ->get();

        $product_bottom = Product::whereHas('collections', function($query){
            $query->where('name', 'ART PIECES');
        })->withCount('attributes')->where('status', 'Published')
        //->skip($initialCount)
        ->limit($initialCount)
        ->inRandomOrder()
        ->get();

        return view('front-end.welcome', compact('products', 'product_bottom','legacyProducts'));
    }

    public function productListing($slug){

        // return Product::with(['categories' => function($query){
        //     $query->whereIn('categories.id', [6, 11]);
        // }])->get();

        // return Product::join('product_categories', 'product_categories.product_id', '=', 'products.id')
        // ->join('categories', 'product_categories.category_id', '=', 'categories.id')

        //     // ->select('products.*', 'categories.id', 'categories.name as category_name')
        // ->whereIn('product_categories.category_id', [11])
        // ->get();


        $collection = Collection::with('categories')->where('status', 'Published')->whereSlug($slug)->firstOrfail();
        $materials = Material::where('status', 'Published')->get();

        return view('front-end.products.listing', compact('collection', 'materials'));
    }


    public function showSingleProduct($slug){

        $product = Product::with('attributes')->whereSlug($slug)->firstOrfail();

        $attributes = collect([]);
        $attributevalues = [];

        foreach ($product->attributes as $key => $attribute) {

            $value =  get_atttibutevalue($attribute->pivot->attributevalue_id);

            $attributevalues['attribute'] = $attribute->name;
            $attributevalues['value_title'] = $value->title;
            $attributevalues['value_slug'] = $value->slug;
            $attributevalues['value_price'] = $attribute->pivot->attribute_price;
            $attributevalues['value_default'] = $value->default;



            $attributes->push((object)$attributevalues);
        }

        $attributes = $attributes->sortBy('value_price');

        $default_price = default_attribute_price($product->attributes, count($product->attributes));

        $related_products = Product::where('status', 'Published')->withCount('attributes')->where(function($query) use ($product){
            $query->where('collection_id', $product->collection_id)->whereNotIn('id', [$product->id]);
        })->limit(8)->get();

        return view('front-end.products.single', compact('product', 'attributes', 'default_price', 'related_products'));
    }

    public function contact(){

        return view('front-end.pages.contact');
    }

    public function saveContact(Request $request){

        $request->validate([
            'name' => ['required', 'string', 'max:225'],
            'email' => ['required', 'string', 'email', 'max:225'],
            // 'phone_number' => ['nullable', 'string', 'max:225'],
            'message' => ['required', 'string'],
        ]);

        $contact = Contact::create([
            'slug' => uniqid(),
            'name' => $request->name,
            'email' => $request->email,
            // 'phone' => $request->phone_number,
            'message' => $request->message,
        ]);

        return back()->with('success', 'Contact message sent successfully.');
    }



    public function fetchRegions(Request $request){

        if($request->wantsJson()){

            $region = Region::where('country_id', $request->country)->get();

            return response()->json($region);
        }

        abort(404);

    }

    public function houseOfAdinkra(){

        return view('front-end.pages.house-of-adinkra');
    }

    public function customJewelry(){

        return view('front-end.pages.custom-jewelry', ['countries' => Country::all()]);
    }

    public function saveCustomJewelry(Request $request)
    {

        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'country' => ['required', 'integer'],
            'phone' => ['required', 'string', 'max:255'],
            'appointment' => ['required', 'date_format:d/m/Y H:i', 'after_or_equal:' . date('d/m/Y H:i')],
            'other_details' => ['nullable', 'string', 'max:1500'],
            'images' => ['required'],
        ]);

        // return $request;
        $image_paths = [];

        if (request()->has('images')) {

            $image_no = 0;

            foreach ($request->file('images') as $file) {
                $image_no = ++$image_no;
                $extension = strtolower($file->getClientOriginalExtension());
                $file_name = uniqid().'-'.$image_no.'.'.$extension;
                $save = $file->storeAs('public/custom-jewelry', $file_name);

                $image_paths[] = $file_name;

            }
        }

        $custom = Customjewelry::create([
            'slug' => uniqid(),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'country_id' => $request->country,
            'phone' => $request->phone,
            'appointment' => !empty($request->appointment) ? Carbon::createFromFormat('d/m/Y H:i', $request->appointment): null,
            'other_details' => $request->other_details,
            'images' => json_encode($image_paths),
        ]);

        return back()->with('success', 'Request submitted successfully.');

    }

    public function heritage(){

        return view('front-end.pages.newsletter');
    }


    
}
