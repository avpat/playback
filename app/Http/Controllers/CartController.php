<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\CartResource;
use App\Cart;
use App\Product;

class CartController extends Controller
{
    public function store(Request $request)
    {

        $request->validate([
            'sku'       => 'required',
            'quantity'  => 'required',
            'userID'    => 'required'
        ]);

        //check if the sku exists
        if(Product::where('sku', '=', $request->input('sku'))->first())
        {
            $order = Cart::create($request->all());
        } else {
            return response()->json(['error' => 'You need to add the product first'], 500);
        }

        return new CartResource($order);
    }

}
