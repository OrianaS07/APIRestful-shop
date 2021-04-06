<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\UserCollection;

trait ApiResponser{
    private function successResponse($data, $code){
        return response()->json(['data'=>$data, 'code'=>$code],$code);
    }

    protected function errorResponse($message, $code)
    {
        return response()->json(['error'=>$message, 'code'=>$code],$code);
    }

    protected function showAll($collection, $code = 200){
        //$collection = $this->sortData($collection);
        return $this->successResponse($collection, $code);
    }

    protected function showOne($instance, $code = 200){
        return $this->successResponse($instance, $code);
    }

    protected function showMenssage($mensaje, $code=200){
        return $this->successResponse($mensaje, $code);
    }

    protected function sortData($collection){
        if(request()->has('sort_by')){
            $attribute = request()->sort_by;
            $collection = $collection->sort_by->{$attribute};
        }
        return $collection;
    }

    protected function userTokenJWT($token, $user, $code=200){
        return response()->json(['user'=>$user, 'TokenJWT'=>$token],$code);
    }
}
