<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function regions()
    {
        return $this->hasMany(Region::class, 'country_id');
    }

    public function shippings(){
        return $this->belongsToMany(Shipping::class, 'country_shippings');
    }
}
