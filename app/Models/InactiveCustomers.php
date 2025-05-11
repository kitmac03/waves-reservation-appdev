<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InactiveCustomers extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'inactive_customers';

    protected $fillable = [
        'customer_id',
        'inactive_date',
        'deletion_reason',
        'archived_by',
        'status',
    ];

    /**
     * Get the customer who was archived.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the user/admin who archived the customer.
     */
    public function archivedBy()
    {
        return $this->belongsTo(Admin::class, 'archived_by');
    }
}
