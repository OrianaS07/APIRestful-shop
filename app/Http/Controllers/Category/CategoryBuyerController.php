<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\UserCollection;
use App\Models\Category;
use Illuminate\Http\Request;
use Symfony\Polyfill\Ctype\Ctype;

class CategoryBuyerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        $buyers = $category->products()
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
