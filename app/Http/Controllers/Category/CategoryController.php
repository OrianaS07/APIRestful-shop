<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\Category as CategoryResource;
use PhpParser\Node\Stmt\Return_;

class CategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = new CategoryCollection(Category::all());
        return $this->showAll($categories);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'description' => 'required'
        ]);
        $category = Category::create($request->all());
        return $this->showOne(new CategoryResource($category),201);
    }

    public function show(Category $category){
        return $this->showOne(new CategoryResource($category));
    }

    public function update(Request $request, Category $category)
    {
        $category->fill($request->all());
        if($category->isClean()){
            return $this->errorResponse('you must specify at least one different value to update',422);
        }
        $category->save();
        return $this->showOne(new CategoryResource($category));
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return $this->showOne(new CategoryResource($category));
    }
}
