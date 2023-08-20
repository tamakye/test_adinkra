<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function products(){
        return $this->hasMany(Product::class, 'collection_id');
    }

    public function categories(){
        return $this->hasMany(Category::class, 'collection_id');
    }
}
