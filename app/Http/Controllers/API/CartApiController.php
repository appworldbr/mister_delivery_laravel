<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\CartExtra;
use App\Models\Food;
use App\Models\FoodExtra;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartApiController extends Controller
{
    public function index()
    {
        $food = CartResource::collection(Cart::with('extras')->with('food')->currentUser()->get());
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
        $cartData = $request->only(['id', 'quantity', 'observation']);

        $extraData = $request->input('extras');

        Validator::make(array_merge($cartData, ['extras' => $extraData]), [
            'quantity' => ['required', 'integer', 'min:1'],
            'extras' => ['nullable', 'array'],
            'extras.*.id' => ['integer', 'min:1'],
            'extras.*.quantity' => ['integer', 'min:1'],
            'observation' => ['nullable', 'string', 'max:100'],
        ])->validate();

        $food = Food::find($cartData['id']);

        if (!$food) {
            abort(430, __("Food Not Found"));
        }

        if (!$food->getRawOriginal('active')) {
            abort(431, __("Food Not Active"));
        }

        if ($extraData) {
            $foodExtras = FoodExtra::active()->whereIn('id', collect($extraData)->pluck('id'))->get();

            if (count($extraData) != $foodExtras->count()) {
                abort(432, __("Extra Not Found"));
            }

            foreach ($extraData as $extraDataItem) {
                if ($extraDataItem['quantity'] > $foodExtras->where('id', $extraDataItem['id'])->first()->limit) {
                    abort(433, __("Extra Limit Reached"));
                }
            }
        }

        $cart = Cart::create([
            'food_id' => $cartData['id'],
            'quantity' => $cartData['quantity'],
            'observation' => $cartData['observation'] ?? '',
            'user_id' => Auth::id(),
        ]);

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
        $cart = Cart::currentUser()->where('id', $cartId)->first();

        if (!$cart) {
            abort(404, __('Food Not Found'));
        }

        $cartData = $request->only(['quantity', 'observation']);

        $extraData = $request->input('extras');

        Validator::make(array_merge($cartData, ['extras' => $extraData]), [
            'quantity' => ['required', 'integer', 'min:1'],
            'extras' => ['nullable', 'array'],
            'extras.*.id' => ['integer', 'min:1'],
            'extras.*.quantity' => ['integer', 'min:1'],
            'observation' => ['nullable', 'string', 'max:100'],
        ])->validate();

        $foodExtras = FoodExtra::whereIn('id', collect($extraData)->pluck('id'))->get();

        if ($extraData && count($extraData) != $foodExtras->count()) {
            abort(404, __("Extra Not Found"));
        }

        foreach ($extraData as $extraDataItem) {
            if ($extraDataItem['quantity'] > $foodExtras->where('id', $extraDataItem['id'])->first()->limit) {
                abort(404, __("Extra Limit Reached"));
            }
        }

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

    public function increment($cartId)
    {
        $cart = Cart::currentUser()->where('id', $cartId)->first();

        if (!$cart) {
            abort(404, __('Food Not Found'));
        }

        $cart->increment('quantity');

        return response()->json(["success" => true]);
    }

    public function decrement($cartId)
    {
        $cart = Cart::currentUser()->where('id', $cartId)->first();

        if (!$cart) {
            abort(404, __('Food Not Found'));
        }

        if ($cart->quantity <= 1) {
            $cart->quantity = 1;
            $cart->save();
            abort(302, __("Quantity can't be less them one"));
        }

        $cart->decrement('quantity');

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
