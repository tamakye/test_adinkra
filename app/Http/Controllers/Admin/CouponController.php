<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class CouponController extends Controller
{
	public function index(){

		$coupons = Coupon::latest()->get();

		return view('admin.coupons.index', compact('coupons'));
	}


	public function create(){

		$products =  Product::orderBy('name', 'asc')->get();
		$categories =  Category::orderBy('name', 'asc')->get();
		$users =  User::orderBy('first_name', 'asc')->get();

		return view('admin.coupons.create', compact('products', 'categories', 'users'));
	}

	public function store(Request $request){

		$request->validate([
			'coupon_code' => ['required', 'string', 'max:20'],
			'quantity' => ['nullable', 'numeric'],
			'unlimited' => ['nullable', 'string'],
			'discount' => ['required'],
			'apply_on' => ['required'],
			'order_amount' => ['nullable'],
			'product' => ['nullable'],
			'category' => ['nullable'],
			'user' => ['nullable'],
			'start_date' => ['required', 'string'],
			'end_date' => ['nullable', 'string'],
			'expires' => ['nullable', 'string'],
		]);

		$coupon = Coupon::create([
			'coupon' => $request->coupon_code,
			'quantity' => $request->quantity,
			'unlimited' => $request->unlimited,
			'discount' => $request->discount,
			'apply_on' => $request->apply_on,
			'min_order_amount' => $request->order_amount,
			'product_id' => $request->product,
			'category_id' => $request->category,
			'user_id' => $request->user,
			'start_date' => $request->start_date,
			'end_date' => $request->end_date,
			'expires' => $request->expires,
		]);

		return back()->with('success', 'Coupon created successfully.');
	}

	public function edit($coupon){

		$coupon = Coupon::where('coupon', $coupon)->firstOrfail();

		$products =  Product::orderBy('name', 'asc')->get();
		$categories =  Category::orderBy('name', 'asc')->get();
		$users =  User::orderBy('first_name', 'asc')->get();

		return view('admin.coupons.edit', compact('coupon', 'products', 'categories', 'users'));

	}


	public function update(Request $request, $coupon){

		$request->validate([
			'coupon_code' => ['required', 'string', 'max:20'],
			'quantity' => ['nullable', 'numeric'],
			'unlimited' => ['nullable', 'string'],
			'discount' => ['required'],
			'apply_on' => ['required'],
			'order_amount' => ['nullable'],
			'product' => ['nullable'],
			'category' => ['nullable'],
			'user' => ['nullable'],
			'start_date' => ['required', 'string'],
			'end_date' => ['nullable', 'string'],
			'expires' => ['nullable', 'string'],
		]);

		$coupon = Coupon::where('coupon', $coupon)->firstOrfail();

		$coupon->update([
			'quantity' => $request->quantity,
			'unlimited' => $request->unlimited,
			'discount' => $request->discount,
			'apply_on' => $request->apply_on,
			'min_order_amount' => $request->order_amount,
			'product_id' => $request->product,
			'category_id' => $request->category,
			'user_id' => $request->user,
			'start_date' => $request->start_date,
			'end_date' => $request->end_date,
			'expires' => $request->expires,
		]);

		return back()->with('success', 'Coupon updated successfully.');

	}


	public function delete(Request $request){

		$coupon  =  Coupon::where('coupon', $request->coupon)->delete();

		return response()->json(['success' => 'Coupon deleted.']);
	}
}
