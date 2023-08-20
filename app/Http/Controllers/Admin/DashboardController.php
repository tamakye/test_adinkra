<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePagesRequest;
use App\Models\Distributor;
use App\Models\Order;
use App\Models\Page;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
	public function index(){

		$orders = Order::latest()->where('status', 'pending')->get();
		$published_products = Product::where('status', 'Published')->count();
		$draft_products = Product::where('status', 'Draft')->count();
		$users = User::count();
		
		return view('admin.index', compact('orders', 'published_products', 'draft_products', 'users'));
	}

	// ladning page
	public function pagesHome(){

		$page = Page::first();

		return view('admin.pages.home-page', compact('page'));
	}


	/**
	 * Saves a page.
	 *
	 * @param      \App\Http\Requests\StorePagesRequest  $request  The request
	 *
	 * @return     <type>                                ( description_of_the_return_value )
	 */
	public function savePage(Request $request){

		if($request->page == 'top-slider'){
			$request->validate([
				'top_slider_one' => ['required', 'string', 'max:255'],
				'top_slider_two' => ['required', 'string', 'max:255'],
				'top_slider_three' => ['required', 'string', 'max:255'],
			]);

			Page::updateOrCreate(
				['id' => 1], 
				[
					'top_slider_one' => $request->top_slider_one,
					'top_slider_two' => $request->top_slider_two,
					'top_slider_three' => $request->top_slider_three,
				]
			);
		}


		if($request->page == 'adinkra'){
			$request->validate([
				'adinkra_text' => ['required', 'string', 'max:255'],
				'adinkra_image_heading' => ['required', 'string', 'max:255'],
				'adinkra_image_text' => ['required', 'string', 'max:255'],
			]);

			Page::updateOrCreate(
				['id' => 1], 
				[
					'adinkra_text' => $request->adinkra_text,
					'adinkra_image_heading' => $request->adinkra_image_heading,
					'adinkra_image_text' => $request->adinkra_image_text,
				]
			);
		}


		if($request->page == 'legacy'){
			$request->validate([
				'legacy_text' => ['required', 'string', 'max:255'],
				'legacy_image_heading' => ['required', 'string', 'max:255'],
				'legacy_image_text' => ['required', 'string', 'max:255'],
			]);

			Page::updateOrCreate(
				['id' => 1], 
				[
					'legacy_text' => $request->legacy_text,
					'legacy_image_heading' => $request->legacy_image_heading,
					'legacy_image_text' => $request->legacy_image_text,
				]
			);
		}

		if($request->page == 'custom'){
			$request->validate([
				'custom_text' => ['required', 'string', 'max:255'],
				// 'custom_image_heading' => ['required', 'string', 'max:255'],
				// 'custom_image_text' => ['required', 'string', 'max:255'],
			]);

			Page::updateOrCreate(
				['id' => 1], 
				[
					'custom_text' => $request->custom_text,
					'custom_image_heading' => $request->custom_image_heading,
					'custom_image_text' => $request->custom_image_text,
				]
			);
		}


		if($request->page == 'art'){
			$request->validate([
				'art_text' => ['required', 'string', 'max:255'],
				'art_image_heading' => ['required', 'string', 'max:255'],
				'art_image_text' => ['required', 'string', 'max:255'],
			]);

			Page::updateOrCreate(
				['id' => 1], 
				[
					'art_text' => $request->art_text,
					'art_image_heading' => $request->art_image_heading,
					'art_image_text' => $request->art_image_text,
				]
			);
		}

		
		if($request->page == 'digital'){
			$request->validate([
				'digital_text' => ['required', 'string', 'max:255'],
				// 'digital_image_heading' => ['required', 'string', 'max:255'],
				// 'digital_image_text' => ['required', 'string', 'max:255'],
			]);

			Page::updateOrCreate(
				['id' => 1], 
				[
					'digital_text' => $request->digital_text,
					'digital_image_heading' => $request->digital_image_heading,
					'digital_image_text' => $request->digital_image_text,
				]
			);
		}

		
		cache()->forget('page');

		cache()->rememberForever('page', function () {
			return Page::first();
		});

		return back()->with('success', 'Records saved successfully');

	}

	
	
	

}