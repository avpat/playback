<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    protected $fillable = [
      'sku','title', 'description', 'color', 'quantity'
    ];
}
