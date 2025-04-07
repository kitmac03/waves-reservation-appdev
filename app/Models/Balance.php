<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'balance';

    // Fillable fields (to avoid mass-assignment issues)
    protected $fillable = [
        'bill_id',
        'dp_id',
        'balance',
        'status',
        'received_by'
    ];

    // Define the relationships (optional based on your schema)
    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }

    public function downPayment()
    {
        return $this->belongsTo(DownPayment::class, 'dp_id');
    }
}
