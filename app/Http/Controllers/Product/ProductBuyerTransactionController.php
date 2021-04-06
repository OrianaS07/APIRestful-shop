<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Resources\Transaction as ResourcesTransaction;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductBuyerTransactionController extends ApiController
{
    
    public function store(Request $request, Product $product, User $buyer)
    {
        $request->validate([
            'quantity' => 'required|min:1'
        ]);

        if($buyer->id == $product->user_id){
            return $this->errorResponse('Buyer must be different from seller',409);
        }
        
        // si es usuario es verificardo?

        if(!$product->estaDisponible()){
            return $this->errorResponse('The product for this transaction is not available',409);
        }

        if($product->quantity < $request->quantity){
            return $this->errorResponse('There is not enough of the product',409);
        }

        return DB::transaction(function () use ($request,$product,$buyer) {
            $product->quantity = $request->quantity;
            $product->save();

            $transaction = Transaction::create([
                'quantity' => $request->quantity,
                'user_id' => $buyer->id,
                'product_id' => $product->id
            ]);
            return $this->showOne(new ResourcesTransaction($transaction));
        });

    }

}
