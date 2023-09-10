<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'color',
        'size',
        'quantity',
        'unit_price',
        // Add any other fields you need
    ];

    public function orderDetail()
    {
        return $this->belongsTo(OrderDetails::class);
    }

    public function product()
    {
        return $this->belongsTo(Products::class);
    }
}
