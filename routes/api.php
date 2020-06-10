<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function (){
    Route::apiResource('/product', 'ProductController')
        ->only(['index', 'store']);
//Add a public API call that allows a client to send product SKU and quantity. Each call to this will also
//include a ‘UserID’ value. This will be used to assign the product to an order.
    Route::apiResource('/order', 'OrderController')
        ->only(['index', 'store']);
});

