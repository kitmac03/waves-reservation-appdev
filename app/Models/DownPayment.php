<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DownPayment extends Model
{
    public $incrementing = false;
    protected $keyType = 'uuid';
    public $timestamps = false;
    protected $table = 'down_payment';

    protected $fillable = [
        'id',
        'res_num',
        'amount',
        'ref_num',
        'img_proof',
        'date',
        'status',
        'verified_by'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'res_num', 'id');
    }
}

