<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Item;

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
        $this->hasMany('Item', 'cart_id');
    }
}
