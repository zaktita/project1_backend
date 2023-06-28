<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $primaryKey = 'product_id';


    protected $fillable = [
        'title',
        'slug',
        'description',
        'category_id',
        'colors',
        'sizes',
        'quantity',
        'price',
        'image',
        // Add any other fields you need
    ];

    protected $casts = [
        'category_id' => 'array',
        'colors' => 'array',
        'sizes' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }
}
