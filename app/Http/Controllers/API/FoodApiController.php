<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\FoodResource;
use App\Models\Food;
use Illuminate\Http\Request;

class FoodApiController extends Controller
{
    public function index(Request $request)
    {
        $query = Food::active();
        if ($search = $request->query('q')) {
            $query->where('name', 'like', "%$search%");
        }
        $food = FoodResource::collection($query->get());
        return response()->json(compact('food'));
    }

    public function category($categoryId, Request $request)
    {
        $query = Food::active()->where('category_id', $categoryId);
        if ($search = $request->query('q')) {
            $query->where('name', 'like', "%$search%");
        }
        $food = FoodResource::collection($query->get());
        return response()->json(compact('food'));
    }

    public function show($foodId)
    {
        $food = new FoodResource(Food::with('extras')->find($foodId));
        return response()->json(compact('food'));
    }
}
