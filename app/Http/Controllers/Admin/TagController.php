<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Carmake;
use Illuminate\Http\Request;

class TagController extends Controller
{
	public function index(){

		$tags = Carmake::all();

		return view('dashboard.tags.index', compact('tags'));
	}

	public function saveTag(Request $request){

		return $request;
	}
}
