<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSizes extends Model
{
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'size',
        
        // Add any other fields you need
    ];
}
