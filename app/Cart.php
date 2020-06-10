<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $keyType = 'string';
    protected $guarded = [];
    public $incrementing = false;

    protected $fillable = [
        'sku', 'products', 'quantity','userID'
    ];

}
