<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Bill extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'res_num',
        'grand_total',
        'date',
        'status',
    ];

    protected $casts = [
        'date' => 'datetime',
        'grand_total' => 'decimal:2',
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'res_num', 'id')->withDefault();
    }

    public function balance()
    {
        return $this->hasOne(Balance::class, 'bill_id');
    }

    public function getGrandTotalAttribute($value)
    {
        if ($this->reservation) {
            return $this->reservation->total_price;
        }
        return $value;
    }
    
}