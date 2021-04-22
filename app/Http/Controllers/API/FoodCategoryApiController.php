<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\FoodCategoryResource;
use App\Models\FoodCategory;

class FoodCategoryApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'categories' => FoodCategoryResource::collection(FoodCategory::all()),
        ]);
    }
}
