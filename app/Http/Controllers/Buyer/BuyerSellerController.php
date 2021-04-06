<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuyerSellerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $buyer)
    {
        $sellers = $buyer->transactions()->with('product.user')
                    ->get()
                    ->pluck('product.user')
                    ->unique('id')
                    ->values();
        
        return $this->showAll(new UserCollection($sellers));
    }

    public function getCurrentBuyerSeller(){
        $buyer = Auth::user();
        $sellers = $buyer->transactions()->with('product.user')
                    ->get()
                    ->pluck('product.user')
                    ->unique('id')
                    ->values();
        return $this->showAll(new UserCollection($sellers));
    }
    
}
