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
            'userId'    => 'required'
        ]);

        //check if the sku exists
        if(Product::where('sku', '=', $request->input('sku'))->first())
        {
            $cart = Cart::create([
                'id'        => md5(uniqid(rand(), true)),
                'key'       => md5(uniqid(rand(), true)),
                'userId'    => $request->input('userId'),
                'sku'       => $request->input('sku'),
                'quantity'  => $request->input('quantity')
            ]);

            return new CartResource([
                'Message' => 'Successfully created the cart',
                'cartId' => $cart->id,
                'cartKey' => $cart->key,
            ]);

        } else {
            return response()->json(['error' => 'You need to add the product first'], 403);
        }


    }

}
