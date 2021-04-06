<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Transaction as TransactionResource;
use App\Http\Resources\TransactionCollection;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionController extends ApiController
{
    
    public function index()
    {
        $transactions = Transaction::all();
        return $this->showAll(new TransactionCollection($transactions));
    }

    public function show(Transaction $transaction)
    {
        return $this->showOne(new TransactionResource($transaction));
    }

    public function getCurrentUserTransactions(){
        $user = Auth::user();
        $transactions = $user->transactions;
        return $this->showAll(new TransactionCollection($transactions));
    }

}
