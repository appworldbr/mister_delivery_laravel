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

    public function show($favoriteId)
    {
        $foodFavorite = FoodFavorite::currentUser()->with('food')->with('extras')->where('id', $favoriteId)->first();
        if (!$foodFavorite) {
            abort(404, __("Food Not Found"));
        }
        return response()->json(new FoodFavoriteResource($foodFavorite));
    }

    public function store(Request $request)
    {
        $favoriteData = $request->only(['food_id', 'observation']);

        $extraData = $request->input('extras');

        Validator::make(array_merge($favoriteData, ['extras' => $extraData]), [
            'food_id' => ['required', 'exists:food,id'],
            'extras' => ['nullable', 'array'],
            'extras.*.id' => ['integer', 'min:1'],
            'extras.*.quantity' => ['integer', 'min:1'],
            'observation' => ['nullable', 'string', 'max:100'],
        ])->validate();

        $foodExtras = FoodExtra::whereIn('id', collect($extraData)->pluck('id'))->get();

        if ($extraData && count($extraData) != $foodExtras->count()) {
            abort(404, "Extra Not Found");
        }

        foreach ($extraData as $extraDataItem) {
            if ($extraDataItem['quantity'] > $foodExtras->where('id', $extraDataItem['id'])->first()->limit) {
                abort(404, "Extra Limit Reached");
            }
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

    public function update($favoriteId, Request $request)
    {
        $favoriteData = $request->only(['food_id', 'observation']);

        $extraData = $request->input('extras');

        Validator::make(array_merge($favoriteData, ['extras' => $extraData]), [
            'food_id' => ['exists:food,id'],
            'extras' => ['nullable', 'array'],
            'extras.*.id' => ['integer', 'min:1'],
            'extras.*.quantity' => ['integer', 'min:1'],
            'observation' => ['nullable', 'string', 'max:100'],
        ])->validate();

        $foodExtras = FoodExtra::whereIn('id', collect($extraData)->pluck('id'))->get();

        if ($extraData && count($extraData) != $foodExtras->count()) {
            abort(404, "Extra Not Found");
        }

        foreach ($extraData as $extraDataItem) {
            if ($extraDataItem['quantity'] > $foodExtras->where('id', $extraDataItem['id'])->first()->limit) {
                abort(404, "Extra Limit Reached");
            }
        }

        $favoriteData['user_id'] = Auth::id();
        $foodFavorite = FoodFavorite::currentUser()->where('id', $favoriteId)->first();
        $foodFavorite->update($favoriteData);

        if ($extraData) {
            $extraData = array_map(function ($extra) use ($foodFavorite) {
                return [
                    'extra_id' => $extra['id'],
                    'favorite_id' => $foodFavorite->id,
                    'quantity' => $extra['quantity'],
                ];
            }, $extraData);
            FoodExtraFavorite::upsert($extraData, ['extra_id', 'favorite_id'], ['quantity']);
        }

        return response()->json(["success" => true]);
    }

    public function delete($favoriteId)
    {
        if (!FoodFavorite::currentUser()->where('id', $favoriteId)->delete()) {
            abort(404, __("Food Not Found"));
        }
        return response()->json(["success" => true]);
    }
}
