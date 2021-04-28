<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\FoodFavoriteResource;
use App\Models\FoodExtra;
use App\Models\FoodExtraFavorite;
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

    public function show($foodId)
    {
        $foodFavorite = FoodFavorite::currentUser()->with('food')->with('extras')->where('id', $foodId)->first();
        return response()->json(new FoodFavoriteResource($foodFavorite));
    }

    public function store($foodId, Request $request)
    {
        $favoriteData = $request->only(['observation']);
        $favoriteData['food_id'] = $foodId;

        $extraData = $request->input('extras');

        Validator::make(array_merge($favoriteData, ['extras' => $extraData]), [
            'food_id' => ['exists:food,id'],
            'extras' => ['nullable', 'array'],
            'extras.*.id' => ['integer', 'min:1'],
            'extras.*.quantity' => ['integer', 'min:1'],
            'observation' => ['nullable', 'string', 'max:100'],
        ])->validate();

        if ($extraData && count($extraData) != FoodExtra::whereIn('id', collect($extraData)->pluck('id'))->count()) {
            abort(404, "Extra Not Found");
        }

        $favoriteData['user_id'] = Auth::id();
        $foodFavorite = FoodFavorite::create($favoriteData);

        if ($extraData) {
            $extraData = array_map(function ($extra) use ($foodFavorite) {
                return [
                    'extra_id' => $extra['id'],
                    'favorite_id' => $foodFavorite->id,
                    'quantity' => $extra['quantity'],
                ];
            }, $extraData);
            FoodExtraFavorite::insert($extraData);
        }

        return response()->json(["success" => true]);
    }

    public function delete($foodId)
    {
        if (!FoodFavorite::currentUser()->where('id', $foodId)->delete()) {
            abort(404, __("Food Not Found"));
        }
        return response()->json(["success" => true]);
    }
}
