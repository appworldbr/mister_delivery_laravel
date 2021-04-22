<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\FoodResource;
use App\Models\Food;

class FoodApiController extends Controller
{
    public function index()
    {
        $food = FoodResource::collection(Food::active()->get());
        return response()->json(compact('food'));
    }

    public function show(Food $food)
    {
        $food = new FoodResource($food);
        return response()->json(compact('food'));
    }

    public function category($categoryId)
    {
        $food = FoodResource::collection(Food::active()->where('category_id', $categoryId)->get());
        return response()->json(compact('food'));
    }
}
