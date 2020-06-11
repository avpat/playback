<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['cart_id', 'sku', 'quantity'];

    public $incrementing = false;

    public function product()
    {
        return $this->hasOne(Product::class);
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }
}
