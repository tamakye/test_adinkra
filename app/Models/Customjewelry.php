<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;


class Customjewelry extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'appointment' => 'datetime',
    ];

    protected $appends = ['full_name'];

    public function fullName(): Attribute
    {
        return new Attribute(
            get: fn () => $this->first_name.' '.$this->last_name,
        );
    }

    public function countries()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
