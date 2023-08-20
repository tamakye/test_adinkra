<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Wishlist extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id');
        
    }

    public static function wishlistExist(){

        $wishlist =  static::where(['user' => get_wishlist_id()])->count();

        return $wishlist > 0 ? true : false;

    }

    public static function addWishlist($product){

        $wishlist = static::where(['product_id' => $product->id, 'user' => get_wishlist_id()])->first();

        if(empty($wishlist)){

            return static::create(
                [
                    'user' => set_wishlist_id(),
                    'product_id' => $product->id,
                ]);

        }

    }


    // public static function updateCart($product_id, $quantity){

    //     $wishlist = static::where(['id' => $product_id, 'user' => get_wishlist_id()])->first();

    //     $wishlist->update([
    //         'quantity' => $quantity,
    //         'total' => $quantity * $wishlist->price,
    //     ]);

    // }

    public static function remove($id){

        return static::where(['user' => get_wishlist_id()])->orWhere('user', Auth::user()->slug)->delete();

    }


    public static function clearCart(){

        return static::where(['user' => get_wishlist_id()])->delete();

    }
}
