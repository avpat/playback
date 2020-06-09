<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
use \App\Http\Resources\V1\ProductResource;
use \App\Product;


Route::prefix('v1')->group(function (){
    Route::get('/products', function(){
        return new ProductResource(Product::all());
    })->name('products.list');
});

