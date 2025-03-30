<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservedAmenity extends Model
{
    use HasFactory;

    protected $table = 'reserved_amenity';

    protected $fillable = [
        'res_num',
        'amenity_id',
    ];

    public $timestamps = false;

    // Relationship to Amenity
    public function amenity()
    {
        return $this->belongsTo(Amenities::class, 'amenity_id');
    }

    // Relationship to Reservation
    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'res_num');
    }
}
