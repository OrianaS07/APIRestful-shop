<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class BuyerController extends ApiController
{
    public function index()
    {
        $buyers = User::all();
        return $this->showAll($buyers);
    }

    public function show(User $buyer)
    {
        return $this->showOne($buyer);
    }
}
