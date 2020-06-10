<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ProductResourceCollection;
use App\Http\Resources\V1\ProductResource;
use App\Product;

class ProductController extends Controller
{

    public function index(): ProductResourceCollection
    {
        return new ProductResourceCollection(Product::paginate());
    }

    public function store()
    {

    }

    public function show($uuid, $quantity): ProductResource
    {
        $product = Product::where('id', $uuid)->get();
        return new ProductResource($product);
    }

    public function update(Product $product): ProductResource
    {
        return new ProductResource($product);
    }

    public function destroy()
    {

    }


}
