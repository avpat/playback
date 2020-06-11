<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function (){
    Route::apiResource('/product', 'ProductController')
        ->only(['index', 'store']);

    Route::apiResource('/cart', 'CartController')
        ->only(['index', 'store']);

    Route::apiResource('/order', 'OrderController')
        ->only(['index', 'store']);

    Route::post('/cart/checkout', 'CartController@checkout');
});

