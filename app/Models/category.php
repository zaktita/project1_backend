<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $primaryKey = 'category_id';
    
    protected $fillable = [
        'category_name',
        'category_slug',
        'category_description',
        'category_image',
        // Add any other fields you need
    ];
    public function products()
    {
        return $this->hasMany(products::class);
    }
}
