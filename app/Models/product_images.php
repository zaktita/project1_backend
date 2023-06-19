<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = [
        'product_id',
        'image_path',
        // Add any other fields you need
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
