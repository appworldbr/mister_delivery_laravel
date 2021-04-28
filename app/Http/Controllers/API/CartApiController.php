<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\CartExtra;
use App\Models\FoodExtra;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartApiController extends Controller
{
    public function index()
    {
        $food = CartResource::collection(Cart::with('food')->currentUser()->get());
        return response()->json(compact('food'));
    }

    public function show($cartId)
    {
        $cart = Cart::currentUser()->with('food')->with('extras')->where('id', $cartId)->first();
        if (!$cart) {
            abort(404, __("Food Not Found"));
        }
        return response()->json(new CartResource($cart));
    }

    public function store(Request $request)
    {
        $cartData = $request->only(['food_id', 'observation']);

        $extraData = $request->input('extras');

        Validator::make(array_merge($cartData, ['extras' => $extraData]), [
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

        $cartData['user_id'] = Auth::id();
        $cart = Cart::create($cartData);

        if ($extraData) {
            $extraData = array_map(function ($extra) use ($cart) {
                return [
                    'extra_id' => $extra['id'],
                    'cart_id' => $cart->id,
                    'quantity' => $extra['quantity'],
                ];
            }, $extraData);
            CartExtra::insert($extraData);
        }

        return response()->json(["success" => true]);
    }

    public function update($cartId, Request $request)
    {
        $cartData = $request->only(['food_id', 'observation']);

        $extraData = $request->input('extras');

        Validator::make(array_merge($cartData, ['extras' => $extraData]), [
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

        $cartData['user_id'] = Auth::id();
        $cart = Cart::currentUser()->where('id', $cartId)->first();
        $cart->update($cartData);

        if ($extraData) {
            $extraData = array_map(function ($extra) use ($cart) {
                return [
                    'extra_id' => $extra['id'],
                    'cart_id' => $cart->id,
                    'quantity' => $extra['quantity'],
                ];
            }, $extraData);
            CartExtra::upsert($extraData, ['extra_id', 'favorite_id'], ['quantity']);
        }

        return response()->json(["success" => true]);
    }

    public function delete($cartId)
    {
        if (!Cart::currentUser()->where('id', $cartId)->delete()) {
            abort(404, __("Food Not Found"));
        }
        return response()->json(["success" => true]);
    }

    public function clear()
    {
        Cart::currentUser()->delete();
        return response()->json(["success" => true]);
    }
}
