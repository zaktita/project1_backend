<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    protected $fillable = [
        'customer_id',
        'address',
        // Add any other fields you need
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
