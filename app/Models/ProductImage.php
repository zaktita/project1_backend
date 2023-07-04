<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


// changed the file name from producs_images to ProductImage
class ProductImage extends Model
{
    protected $fillable = [
        'product_id',
        'filename',
        // Add any other fields you need
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
