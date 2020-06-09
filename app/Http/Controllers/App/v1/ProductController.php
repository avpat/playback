<?php

namespace App\Http\Controllers\App\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ProductResource;
use Illuminate\Http\Request;
use App\Product;

class ProductController extends Controller
{
    public function show():ProductResource
    {
        $products = ['SKU' => 'HGHJSBBJHBS']; //Product::all();

        return new ProductResource($products);
    }
}
