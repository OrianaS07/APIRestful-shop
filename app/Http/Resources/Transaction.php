<?php

namespace App\Http\Resources;

use App\Models\Product;
use App\Models\User;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\Product as ProductResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Transaction extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => (int)$this->id,
            'quantity' => (int)$this->quantity,
            'buyer' => new UserResource(User::find($this->user_id)),
            'product' => new ProductResource(Product::find($this->product_id)),
            'created_at' => (string)$this->created_at,
            'updated_at' => (string)$this->updated_at,
            'deleted_at' => (string)$this->deleted_at,
        
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('transactions.show',$this->id),
                ],
                [
                    'rel' => 'transactions.categories',
                    'href' => route('transactions.categories.index',$this->id),
                ],
                [
                    'rel' => 'transactions.seller',
                    'href' => route('transactions.sellers.index',$this->id),
                ],
                [
                    'rel' => 'buyer',
                    'href' => route('buyers.show',$this->user_id),
                ],
                [
                    'rel' => 'products',
                    'href' => route('products.show',$this->product_id),
                ],
            ],

        ];
    }
}
