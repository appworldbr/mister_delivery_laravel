<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\FoodResource;
use App\Models\Food;

class FoodApiController extends Controller
{
    public function index($categoryId = null)
    {
        $query = Food::where('active', 1);
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }
        $food = FoodResource::collection($query->get());
        return response()->json(compact('food'));
    }
}
