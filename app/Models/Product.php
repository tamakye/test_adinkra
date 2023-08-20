<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];  
    
    public function collections(){
        return $this->belongsTo(Collection::class, 'collection_id');
    }

    public function materials(){
        return $this->belongsTo(Material::class, 'material_id');
    }


    public function conditions(){
        return $this->belongsToMany(Condition::class, 'product_conditions');
    }

    public function categories(){
        return $this->belongsToMany(Category::class, 'product_categories');
    }

    public function attributes(){
        return $this->belongsToMany(Attribute::class, 'product_attributes')->withPivot('attribute_id', 'attributevalue_id', 'attribute_price');
    }

    // public function productattributes(){
    //     return $this->belongsToMany(Attribute::class, 'product_attributes')->withPivot('attribute_id', 'attributevalue_id', 'attribute_price')->orderBy('product_attributes.attribute_price');
    // }
    
    public function orders(){
        return $this->belongsToMany(Order::class, 'order_products')->withPivot(['quantity', 'price', 'total']);
    }


    // public function mustanglables(){
    //     return $this->belongsTo(Mustanglabel::class, 'mustanglabel_id');
    // }

    public function coupons(){
        return $this->hasOne(Coupon::class, 'product_id');
    }


    public function wishlist(){
        return $this->hasMany(Wishlist::class, 'product_id');
    }
}
