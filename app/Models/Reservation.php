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
        'id',
        'customer_id', 
        'date', 
        'startTime', 
        'endTime', 
        'status'
    ];

    protected static function booted()
    {
         static::retrieved(function ($r) {
        if (! $r->isPastDate()) return;

        $new = $r->areBillsPaid() ? 'completed'
             : ($r->hasPartiallyPaidBill() || $r->hasDownpayment() ? 'cancelled' : 'invalid');

        if ($new !== $r->status) {
            static::withoutEvents(function () use ($r, $new) {
                $r->newQuery()->whereKey($r->getKey())->update(['status' => $new]);
            });
        }
     });
    }

    public function isPastDate(): bool
    {
        $reservationEnd = Carbon::parse($this->date.' '.$this->endTime, 'Asia/Manila');
        return $reservationEnd->isPast();
    }

    protected function hasDownpayment(): bool
    {
        if ($this->relationLoaded('downPayment')) {
        return !is_null($this->downPayment);
        }
        return $this->downPayment()->exists();
    }

    protected function areBillsPaid(): bool
    {
        if ($this->relationLoaded('bill')) {
            return optional($this->bill)->status === 'paid';
        }
        return $this->bill()->exists() && $this->bill()->value('status') === 'paid';
    }

    protected function hasPartiallyPaidBill(): bool
    {
        if ($this->relationLoaded('bill')) {
            return optional($this->bill)->status === 'partially paid';
        }
        return $this->bill()->exists() && $this->bill()->value('status') === 'partially paid';
    }

    public function markAsCompleted(): void
    {
        $this->forceFill(['status' => 'completed'])->save();
    }

    public function markAsInvalid(): void
    {
        $this->forceFill(['status' => 'invalid'])->save();
    }

    public function markAsCancelled(): void
    {
        $this->forceFill(['status' => 'cancelled'])->save();
    }

    public function reservedAmenities()
    {
        return $this->hasMany(ReservedAmenity::class, 'res_num', 'id');
    }

    public function bill()
    {
        return $this->hasOne(Bill::class, 'res_num', 'id')->withDefault();
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function downPayment()
    {
            return $this->hasOne(\App\Models\DownPayment::class, 'res_num', 'id')
                ->orderByDesc('date')
                ->orderByDesc('id');
    }

    public function getHoursAttribute()
    {
        $start = $this->getAttribute('start_time');
        $end   = $this->getAttribute('end_time');

        if (!$start || !$end) {
            return 0.0;
        }

        return \Carbon\Carbon::parse($start)
            ->floatDiffInMinutes(\Carbon\Carbon::parse($end)) / 60;
     }
    public function getTotalPriceAttribute()
    {
        $hours = $this->hours;
        $this->loadMissing('reservedAmenities.amenity');

        return (float) $this->reservedAmenities->sum(function ($ra) use ($hours) {
            return (optional($ra->amenity)->price ?? 0) * $hours;
        });
    }


}