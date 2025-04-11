<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    use HasFactory;

    protected $table = 'balance';

    protected $fillable = [
        'bill_id',
        'dp_id',
        'balance',
        'status',
        'received_by'
    ];

    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }

    public function downPayment()
    {
        return $this->belongsTo(DownPayment::class, 'dp_id');
    }
}
