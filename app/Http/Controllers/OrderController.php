<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResourceCollection;
use App\Http\Resources\OrderResource;
use Illuminate\Http\Request;
use App\Order;
use App\Product;

class OrderController extends Controller
{

    public function index(): OrderResourceCollection
    {
        return new OrderResourceCollection(Order::paginate());
    }

    public function store(Request $request)
    {

        $request->validate([
            'sku'       => 'required',
            'quantity'  => 'required',
            'userId'    => 'required'
        ]);

        //check if the sku exists
        if (Product::where('sku', '=', $request->input('sku'))->first()) {
            $order = Order::create($request->all());
        } else {
            return response()->json(['error' => 'You need to add the product first'], 500);
        }

        return new OrderResource($order);
    }
}
