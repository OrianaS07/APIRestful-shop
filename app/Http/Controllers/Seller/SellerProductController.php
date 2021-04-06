<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Resources\Product as ResourcesProduct;
use App\Http\Resources\ProductCollection;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SellerProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $seller)
    {
        $products = $seller->products;
        return $this->showAll(new ProductCollection($products));
    }

    public function store(Request $request, User $seller)
    {
        $validate = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'quantity' => 'required|integer|min:1',
            'image' => 'required|image'
        ]);

        $data = $request->all();

        $data['status'] = Product::PRODUCTO_NO_DISPONIBLE;
        $data['image'] = $request->image->store('');
        $data['user_id'] = $seller->id;
        
        $product = Product::create($data);

        return $this->showOne(new ResourcesProduct($product), 201);
    }

    public function update(Request $request, User $seller, Product $product)
    {
        $request->validate([
            'quantity' => 'integer|min:1',
            'status' => 'in:'. Product::PRODUCTO_NO_DISPONIBLE . ',' . Product::PRODUCTO_DISPONIBLE,
            'image' => 'image'
        ]);

        $this->verificarVendedor($seller,$product);

        $product->fill($request->all());

        if($request->has('status')){
            $product->status = $request->status;

            if($product->estaDisponible() && $product->categories()->count()==0){
                return $this->errorResponse('An active product must have at least one category',409);
            }
        }

        if($request->hasFile('image')){
            Storage::delete($product->image);

            $product->image = $request->image->store('');
        }

        if($product->isClean()){
            return $this->errorResponse('At least one different value must be specified to update',422);
        }

        $product->save();

        return $this->showOne(new ResourcesProduct($product));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $seller, Product $product)
    {
        $this->verificarVendedor($seller,$product);
        Storage::delete($product->image);
        $product->delete();
        return $this->showOne(new ResourcesProduct($product));
    }

    public function verificarVendedor(User $seller, Product $product){
        if($seller->id != $product->user_id){
            throw new HttpException(422, 'The seller specified is not the actual seller of the product');
        }
    }
}
