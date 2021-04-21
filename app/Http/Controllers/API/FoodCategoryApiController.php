<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\FoodCategory;

class FoodCategoryApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'categories' => FoodCategory::all(),
        ]);
    }
}
