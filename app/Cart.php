<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $keyType = 'string';
    protected $guarded = [];
    public $incrementing = false;

    protected $fillable = [
        'id', 'key', 'userId', 'sku', 'products', 'quantity'
    ];

    public function items()
    {
        return $this->hasMany('App\Item', 'cart_id');
    }
}
