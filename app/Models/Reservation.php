<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // for generating UUIDs

class Reservation extends Model
{
    public $incrementing = false; // Disable auto-incrementing IDs (since UUIDs aren't integers)
    protected $keyType = 'string'; // Set key type as string
    protected $fillable = [
        'customer_id', 
        'date', 
        'startTime', 
        'endTime', 
        'status'
    ];

    // Automatically generate a UUID for the ID when creating a new reservation
    protected static function booted()
    {
        static::creating(function ($reservation) {
            // Generate UUID for the primary key
            if (empty($reservation->id)) {
                $reservation->id = (string) Str::uuid();
            }

            if (empty($reservation->status)) {
                $reservation->status = 'pending';
            }
        });
    }

    public function reservedAmenities()
    {
        return $this->hasMany(ReservedAmenity::class, 'res_num');
    }

    public function bills()
    {
        return $this->hasMany(Bill::class, 'res_num', 'id');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}