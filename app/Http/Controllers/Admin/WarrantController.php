<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Warranty;
use Illuminate\Http\Request;

class WarrantController extends Controller
{
    public function index(){

    	$warranties = Warranty::latest()->get();

    	return view('dashboard.warranties.index', compact('warranties'));
	}
}
