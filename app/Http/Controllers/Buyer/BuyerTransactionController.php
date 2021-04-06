<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionCollection;
use App\Models\User;
use Illuminate\Http\Request;

class BuyerTransactionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $buyer)
    {
        $transactions = $buyer->transactions;
        return $this->showAll(new TransactionCollection($transactions));
    }

}
