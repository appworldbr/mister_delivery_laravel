<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\FoodFavoriteResource;
use App\Models\FoodFavorite;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FoodFavoriteApiController extends Controller
{
    public function index()
    {
        $food = FoodFavoriteResource::collection(FoodFavorite::with('food')->currentUser()->get());
        return response()->json(compact('food'));
    }

    public function store($foodId, Request $request)
    {
        $favoriteData = $request->only(['observation']);
        $favoriteData['food_id'] = $foodId;

        $extraData = $request->only(['extras']);

        Validator::make(array_merge($favoriteData, $extraData), [
            'food_id' => ['exists:food,id'],
            'extras' => ['nullable', 'array'],
            'extras.*.id' => ['exists:food_extras,id'],
            'extras.*.quantity' => ['integer', 'min:1'],
            'observation' => ['nullable', 'string', 'max:100'],
        ])->validate();

        $favoriteData['user_id'] = Auth::id();
        $foodFavorite = FoodFavorite::create($favoriteData);

        dd($extraData, "Insert the Extras");

        return response()->json(["success" => true]);
    }

    public function delete($foodFavoriteId)
    {
        if (!FoodFavorite::currentUser()->where('id', $foodFavoriteId)->delete()) {
            abort(404, __("Food Not Found"));
        }
        return response()->json(["success" => true]);
    }
}
