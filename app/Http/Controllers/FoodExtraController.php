<?php

namespace App\Http\Controllers;

use App\Models\FoodExtra;

class FoodExtraController extends Controller
{
    public function index()
    {
        return view('food_extras.index', [
            'model' => FoodExtra::class,
        ]);
    }

    public function form(FoodExtra $foodExtra = null)
    {
        return view("food_extras.form", compact("foodExtra"));
    }
}
