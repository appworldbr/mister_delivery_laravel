<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\DeliveryArea;
use App\Models\Order;
use App\Models\OrderExtra;
use App\Models\OrderFood;
use App\Models\UserAddress;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderApiController extends Controller
{
    public function index()
    {
        // TODO verificar se é necessário adicionar comidas e extras na query
        $orders = Order::currentUser()->get();
        return response()->json(compact('orders'));
    }

    public function show($orderId)
    {
        // TODO adicionar comidas e extras na query
        $order = Order::currentUser()->where('id', $orderId)->first();
        if (!$order) {
            abort(404, __("Order Not Found"));
        }
        return response()->json($order);
    }

    public function store(Request $request)
    {
        $addressId = $request->input('address_id');

        Validator::make(['address_id' => $addressId], [
            'address_id' => ['required', 'integer', 'min:1'],
        ])->validate();

        $user = Auth::user();
        $address = UserAddress::currentUser($user->id)->where('id', $addressId)->first();

        if (!$address) {
            abort(404, __("Address Not Found"));
        }

        $cart = Cart::currentUser($user->id)->with('food')->with('extras')->get();

        if ($cart && !count($cart)) {
            abort(404, __("Cart Empty"));
        }

        $deliveryArea = DeliveryArea::validationZip($address->zip);
        if (!$deliveryArea) {
            abort(302, __("Area Not Deliverable"));
        }

        $order = Order::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'zip' => $address->zip,
            'state' => $address->state,
            'city' => $address->city,
            'district' => $address->district,
            'address' => $address->address,
            'number' => $address->number,
            'complement' => $address->complement,
            'status' => Order::STATUS_WAITING,
            'delivery_fee_price' => $deliveryArea->getRawOriginal('price'),
        ]);

        foreach ($cart as $item) {
            $orderFood = OrderFood::create([
                'order_id' => $order->id,
                'name' => $item->food->name,
                'price' => $item->food->getRawOriginal('price'),
                'observation' => $item->observation,
            ]);

            if ($item->extras) {
                foreach ($item->extras as $extraItem) {
                    OrderExtra::create([
                        'order_food_id' => $orderFood->id,
                        'name' => $extraItem->extra->name,
                        'quantity' => $extraItem->quantity,
                        'price' => $extraItem->extra->getRawOriginal('price'),
                    ]);
                }
            }
        }

        Cart::currentUser()->delete();

        return response()->json(["success" => true]);
    }
}
