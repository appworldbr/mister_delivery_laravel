<?php

namespace App\Http\Controllers;

use App\Models\FoodCategory;

class FoodCategoryController extends Controller
{
    public function index()
    {
        return view('food_categories.index', [
            'model' => FoodCategory::class,
        ]);
    }

    public function form(FoodCategory $foodCategory = null)
    {
        return view("food_categories.form", compact("foodCategory"));
    }
}
