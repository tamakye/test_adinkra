<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function attributevalues(){
        return $this->hasMany(Attributevalue::class, 'attribute_id');
    }

    public function products(){
        return $this->belongsToMany(Product::class, 'product_attributes')->withPivot('attribute_id', 'attributevalue_id', 'attribute_price');
    }


    // public function aproducts(){
    //     return $this->belongsToMany(Product::class, 'product_attributes')->withPivot('attribute_id', 'attributevalue_id', 'attribute_price')->orderBy('product_attributes.attribute_price');
    // }
}
