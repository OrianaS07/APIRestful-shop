<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Category extends JsonResource
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
            'created_at' => (string)$this->created_at,
            'updated_at' => (string)$this->updated_at,
            'deleted_at' => (string)$this->deleted_at,

            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('categories.show',$this->id),
                ],
                [
                    'rel' => 'category.buyers',
                    'href' => route('categories.buyers.index',$this->id),
                ],
                [
                    'rel' => 'category.sellers',
                    'href' => route('categories.sellers.index',$this->id),
                ],
                [
                    'rel' => 'category.products',
                    'href' => route('categories.products.index',$this->id),
                ],
                [
                    'rel' => 'category.transactions',
                    'href' => route('categories.transactions.index',$this->id),
                ],
            ],            

        ];
    }
}
