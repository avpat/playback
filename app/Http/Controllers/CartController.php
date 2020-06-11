<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItemResourceCollection;
use App\Order;
use Illuminate\Http\Request;
use App\Http\Resources\CartResource;
use App\Cart;
use App\Product;

class CartController extends Controller
{
    /**
     * Store the order to the cart
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|object
     *
     */
    public function store(Request $request)
    {

        $request->validate([
            'sku'       => 'required',
            'quantity'  => 'required',
            'userId'    => 'required'
        ]);

        $sku        = $request->input('sku');
        $userId     = $request->input('userId');
        $quantity   = $request->input('quantity');

        //check if the sku exists in Products table
        $product = Product::where('sku', '=', $sku)->first();

        if ($product) {
            //check if the item is in the cart.. if yes, then update
            $cartItem = Cart::where(['userId' => $userId, 'sku' => $sku])->first();
            $totalQuantity = 0;
            if ($cartItem) {
                $cartItem->quantity += $quantity; // add previously added items + new one
                //check if there are more items added to the cart than the stock then show error
                if ($product->stock >= $cartItem->quantity) {
                    Cart::where(['userId' => $userId, 'sku' => $sku])->update(['quantity' => $cartItem->quantity]);
                } else {
                    return response()->json(['error' => 'You have added more products in cart than stock'], 403);
                }
            } else {
                $totalQuantity += $quantity;
                //check if there are more items added to the cart than the stock then show error
                if ($product->stock >= $totalQuantity) {
                    $cartItem = Cart::create([
                        'id'        => md5(uniqid(rand(), true)),
                        'key'       => md5(uniqid(rand(), true)),
                        'userId'    => $userId,
                        'sku'       => $sku,
                        'quantity'  => $totalQuantity
                    ]);
                } else {
                    return response()->json(['error' => 'You have added more products in cart than stock'], 403);
                }
            }

            return (new CartResource([
                'Message'   => 'The selected products have been added to the cart',
                'cartId'    => $cartItem->id,
                'cartKey'   => $cartItem->key,
                'sku'       => $cartItem->sku,
                'userId'    => $cartItem->userId
            ]))->response()->setStatusCode(200);
        } else {
            return response()->json(['error' => 'Product not available'], 403);
        }
    }

    /**
     * Checkout
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkout(Request $request)
    {

        $request->validate([
            'userId'    => 'required'
        ]);

        $totalPrice = (float) 0.0;
        $totalItems = 0;
        $userId = $request->input('userId');
        //based on the userId get order from the cart
        $cartItems = Cart::where('userId', '=', $userId)->get();

        foreach ($cartItems as $cartItem) {
            //If required quantity is still in the product list then
            $product = Product::where('sku', '=', $cartItem->sku)->first();

            $price = $product->price;
            if ($product->stock >= $cartItem->quantity) {
                $totalPrice = $totalPrice + ($price * $cartItem->quantity);
                $product->stock = $product->stock - $cartItem->quantity;
                $totalItems += $cartItem->quantity;
                $product->save();
            } else {
                return response()->json(['error' => 'Not enough products available in stock'], 403);
            }
        }
        //lets assume payment gateway is set

        $paymentGateway = true;
        $transactionId = md5(uniqid(rand(), true));
        if ($paymentGateway) {
            $orders = Order::create([
                'sku'           => json_encode(new ItemResourceCollection($cartItems)),
                'totalPrice'    => $totalPrice,
                'quantity'      => $totalItems,
                'userId'        => isset($userId) ? $userId : null,
                'transactionId' => $transactionId
            ]);
            //delete the record from the cart
            Cart::where('userId', $userId)->delete();
            return response()->json([
                'message'   => 'your order has been completed successfully',
                'orders'   => $orders
            ], 200);
        } else {
            return response()->json([
                'message' => 'The cart key you provided does not match the Key for this Cart.',
            ], 400);
        }
    }
}
