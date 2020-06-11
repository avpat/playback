<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ProductResourceCollection;
use App\Http\Resources\ProductResource;
use App\Product;

class ProductController extends Controller
{

    public function index(): ProductResourceCollection
    {
        return new ProductResourceCollection(Product::paginate());
    }

    public function store(Request $request)
    {

        $request->validate([
           'sku'    => 'required',
           'title'  => 'required'
        ]);
            //check if the numbers are digits

        $product = Product::create($request->all());
        return new ProductResource($product);
    }
}
