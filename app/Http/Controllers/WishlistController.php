<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function addToWishlist(Request $request){

        $product = Product::whereSlug($request->product)->first();

        Wishlist::addWishlist($product);

        return response()->json(['success' => 'Item added to Wishlist.']);
    }
}
