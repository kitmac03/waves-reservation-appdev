<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // for generating UUIDs
use Carbon\Carbon; // for date comparison

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

        // Add the automatic status update logic
        static::retrieved(function ($reservation) {
            if ($reservation->shouldBeCompleted()) {
                $reservation->markAsCompleted();
            }
        });
    }

    /**
     * Determine if the reservation should be marked as completed
     */
    public function shouldBeCompleted(): bool
    {
        // Combine date and endTime to get the full end datetime
        $reservationEnd = Carbon::parse($this->date.' '.$this->endTime);
        
        return $reservationEnd->isPast() 
            && $this->areBillsPaid() 
            && $this->status !== 'completed';
    }

    /**
     * Check if all bills are paid
     */
    protected function areBillsPaid(): bool
    {
        if ($this->bills->isEmpty()) {
            return false; // or true, depending on your business logic
        }

        return $this->bills->every(function ($bill) {
            return $bill->status === 'paid';
        });
    }

    /**
     * Mark the reservation as completed
     */
    public function markAsCompleted(): void
    {
        $this->status = 'completed';
        $this->save();
    }

    // Your existing relationships...
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

    public function downPayment()
    {
        return $this->hasOne(DownPayment::class, 'res_num', 'id')->latestOfMany('date');
    }
}