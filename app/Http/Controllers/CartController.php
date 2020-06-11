<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\CartResource;
use App\Cart;
use App\Product;
Use App\Item;

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

            return (new CartResource([
                'Message'   => 'Successfully created the cart',
                'cartId'    => $cart->id,
                'cartKey'   => $cart->key,
                'sku'       => $cart->sku,
                'userId'    => $cart->userId
            ]))->response()->setStatusCode(200);

        } else {
            return response()->json(['error' => 'You need to add the product first'], 403);
        }
    }

    public function checkout(Request $request)
    {

        $request->validate([
            'cartKey'   => 'required',
            'sku'       => 'required',
            'userId'    => 'required'
        ]);

        $cart = Cart::where('key','=', $request->input('cartKey'))->first();

       // dd($cart);
        if($cart->key == $request->input('cartKey'))
        {
            //check if the product still valid
            if(Product::where('sku', '=', $request->input('sku'))->first()){
                $cartItem = Item::where(['cart_id' => $cart->getKey(), 'sku' => $request->input('sku')])->first();
                if($cartItem)
                {
                    $cartItem->quantity = $cart->quantity;
                    Item::where(['cart_id' => $request->input('cartKey'), 'sku' => $request->input('sku')])->update(['quantity' => $cart->quantity]);
                } else {
                    Item::create(['cart_id' => $request->input('cartKey'), 'sku' => $request->input('sku'), 'quantity' => $cart->quantity]);
                }

                return (new CartResource($cartItem))->response()->setStatusCode(200);

            }else {
                return response()->json(['error' => 'You need to add the product first'], 500);
            }
        }

    }

}
