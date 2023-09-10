<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductColors extends Model
{
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'color_name',
        
        // Add any other fields you need
    ];
}
