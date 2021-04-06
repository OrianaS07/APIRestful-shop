<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\Product as ProductResource;
use App\Http\Resources\ProductCollection;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProductController extends ApiController
{
    
    public function index()
    {
        $products = Product::all();
        return $this->showAll(new ProductCollection($products));
    }

    
    public function show(Product $product)
    {
        return $this->showOne(new ProductResource($product));
    }

    public function getUserProduct()
    {
        return 'hola';
    }
    
}
