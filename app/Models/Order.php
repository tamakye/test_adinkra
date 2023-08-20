<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'order_date' => 'datetime', 
        'payment_date' => 'datetime',
        'refunded_at' => 'datetime',
    ];

    public function products(){
        return $this->belongsToMany(Product::class, 'order_products')->withPivot(['quantity', 'price', 'total']);
    }

    public function addresses(){
        return $this->belongsTo(Address::class, 'address_id');
    }

    public function users(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
