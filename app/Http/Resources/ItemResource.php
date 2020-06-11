<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Product;

class ItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
      //  dd($this->id);
        $product = Product::where('sku','=',$this->sku)->firstOrFail();


        return [
            'ProductNo' => $product->sku,
            'Price' => $product->price,
            'Title' => $product->title,
            'Color' => $product->color,
            'Quantity' => $this->quantity,
        ];
    }
}
