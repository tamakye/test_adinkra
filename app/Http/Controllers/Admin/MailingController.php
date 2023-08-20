<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customjewelry;
use App\Models\NewsLetter;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class MailingController extends Controller
{

	public function subscribers(){

		$subscribers = Subscriber::latest()->get();
		return view('admin.mailing.subscribers', compact('subscribers'));
	}

	public function deleteSubscriber(Request $request){

		Subscriber::whereSlug($request->slug)->delete();

		return back()->with('success', 'Record deleted successfully.');
	}

	public function newsLetter(){

		$subscribers = NewsLetter::latest()->get();
		return view('admin.mailing.news-letter', compact('subscribers'));
	}


	public function customJewelry(){

		$customjewelries = Customjewelry::latest()->get();
		return view('admin.mailing.custom-jewelry', compact('customjewelries'));
	}

	public function showCustomJewelry($slug){

		$customjewelry = Customjewelry::whereSlug($slug)->firstOrfail();
		return view('admin.mailing.custom-jewelry-details', compact('customjewelry'));
	}
}
