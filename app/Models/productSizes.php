<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class productSizes extends Model
{
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'size',
        
        // Add any other fields you need
    ];
}
