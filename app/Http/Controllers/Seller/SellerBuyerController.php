<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;
use App\Models\User;
use Illuminate\Http\Request;

class SellerBuyerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $seller)
    {
        $buyers = $seller->products()
            ->whereHas('transactions')
            ->with('transactions.user')
            ->get()
            ->pluck('transactions')
            ->collapse()
            ->pluck('user')
            ->unique()
            ->values();
        
        return $this->showAll(new UserCollection($buyers));
    }

}
