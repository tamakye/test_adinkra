<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;


    protected $guarded = [];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function products(){
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function categories(){
        return $this->belongsTo(Category::class, 'category_id');
    }

     public function users(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
