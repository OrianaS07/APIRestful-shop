<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryCollection;
use App\Models\User;
use Illuminate\Http\Request;

class BuyerCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $buyer)
    {
        $categories = $buyer->transactions()->with('product.categories')
                    ->get()
                    ->pluck('product.categories')
                    ->collapse()
                    ->unique('id')
                    ->values();
        return $this->showAll(new CategoryCollection($categories));
    }

}
