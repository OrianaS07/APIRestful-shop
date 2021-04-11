<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
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
            'name' => (string)$this->name,
            'email' => (string)$this->email,
            'verified' => (string)$this->verified,
            'verification_token' => (string) $this->verification_token,
            'created_at' => (string)$this->created_at,
            'updated_at' => (string)$this->updated_at,
            'deleted_at' => (string)$this->deleted_at,

            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('users.show',$this->id),
                ],
                //buyer
                [
                    'rel' => 'buyers.categories',
                    'href' => route('buyers.categories.index',$this->id),
                ],
                [
                    'rel' => 'buyers.products',
                    'href' => route('buyers.products.index',$this->id),
                ],
                [
                    'rel' => 'buyers.sellers',
                    'href' => route('buyers.sellers.index',$this->id),
                ],
                [
                    'rel' => 'buyers.transactions',
                    'href' => route('buyers.transactions.index',$this->id),
                ],
                //seller
                [
                    'rel' => 'sellers.buyers',
                    'href' => route('sellers.buyers.index',$this->id),
                ],
                [
                    'rel' => 'sellers.categories',
                    'href' => route('sellers.categories.index',$this->id),
                ],
                [
                    'rel' => 'sellers.products',
                    'href' => route('sellers.products.index',$this->id),
                ],
                [
                    'rel' => 'sellers.transactions',
                    'href' => route('sellers.transactions.index',$this->id),
                ],
            ],
        ];
    }
}
