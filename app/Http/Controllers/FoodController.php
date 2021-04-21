<?php

namespace App\Http\Controllers;

use App\Models\Food;

class FoodController extends Controller
{
    public function index()
    {
        return view('foods.index', [
            'model' => Food::class,
        ]);
    }

    public function form(Food $food = null)
    {
        return view("foods.form", compact("food"));
    }
}
