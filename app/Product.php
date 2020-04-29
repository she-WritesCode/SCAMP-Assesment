<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $fillable = [
        'name',
        'quantity',
        'price',
        'description',
        'category_id',
        'user_id',
    ];
}
