<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Amenities extends Model
{
    protected $table = 'amenities'; 

    protected $fillable = [
        'name',
        'price',
        'type',
        'is_active',
        'added_by',
    ];
    protected $casts = [
        'is_active' => 'boolean',
    ];
}
