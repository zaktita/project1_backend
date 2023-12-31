<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'amount',
        'type',
        // Add any other fields you need
    ];

    public function order()
    {
        return $this->belongsTo(Orders::class);
    }
}
