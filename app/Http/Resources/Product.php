<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Http\Resources\User as UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
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
            'title' => (string)$this->name,
            'description' => (string)$this->description,
            'quantity' => (int)$this->quantity,
            'status' => (string)$this->status,
            'image' => url('img/{$user->image}'),
            'buyer' => new UserResource(User::find($this->user_id)),
            'created_at' => (string)$this->created_at,
            'updated_at' => (string)$this->updated_at,
            'deleted_at' => (string)$this->deleted_at,

            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('products.show',$this->id),
                ],
                [
                    'rel' => 'products.buyers',
                    'href' => route('products.buyers.index',$this->id),
                ],
                [
                    'rel' => 'products.categories',
                    'href' => route('products.categories.index',$this->id),
                ],
                [
                    'rel' => 'products.transactions',
                    'href' => route('products.transactions.index',$this->id),
                ],
                [
                    'rel' => 'seller',
                    'href' => route('sellers.show',$this->user_id),
                ],
            ],            

        ];
    }
}
