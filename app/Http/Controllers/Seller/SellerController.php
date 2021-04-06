<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class SellerController extends ApiController
{
    public function index()
    {
        $sellers = User::all();
        return $this->showAll($sellers,200);
    }

    public function show(User $seller)
    {
        return $this->showOne($seller);
    }
}
