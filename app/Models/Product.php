<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'price', 'category_slug', 'in_stock'];

    protected $casts = [
        'in_stock' => 'boolean',
        'price' => 'float',
    ];
}
