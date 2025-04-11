<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; 
use Carbon\Carbon; 

class Reservation extends Model
{
    public $incrementing = false;
    protected $keyType = 'string'; 
    protected $fillable = [
        'customer_id', 
        'date', 
        'startTime', 
        'endTime', 
        'status'
    ];

    protected static function booted()
    {
        static::creating(function ($reservation) {
            if (empty($reservation->id)) {
                $reservation->id = (string) Str::uuid();
            }

            if (empty($reservation->status)) {
                $reservation->status = 'pending';
            }
        });
        /**
         * added automatic invalid for reservation base on reservation past date and no downpayment
         */
        static::retrieved(function ($reservation) {
            if ($reservation->isPastDate() && !$reservation->hasDownpayment()) {
                $reservation->markAsInvalid();
            }
            elseif ($reservation->isPastDate() && $reservation->areBillsPaid()) {
                $reservation->markAsCompleted();
            }
        });
    }
    
    public function isPastDate(): bool
    {
        $reservationEnd = Carbon::parse($this->date.' '.$this->endTime);
        return $reservationEnd->isPast();
    }

    protected function hasDownpayment(): bool
    {
        return $this->downPayment()->exists(); 
    }

    protected function areBillsPaid(): bool
    {
        if ($this->bills->isEmpty()) {
            return false;
        }

        return $this->bills->every(function ($bill) {
            return $bill->status === 'paid';
        });
    }


    public function markAsCompleted(): void
    {
        $this->status = 'completed';
        $this->save();
    }

    public function markAsInvalid(): void
    {
        $this->status = 'invalid';
        $this->save();
    }

    public function reservedAmenities()
    {
        return $this->hasMany(ReservedAmenity::class, 'res_num');
    }

    public function bills()
    {
        return $this->hasmany(Bill::class, 'res_num', 'id');
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
