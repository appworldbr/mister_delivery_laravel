<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Cart;
use App\Models\DeliveryArea;
use App\Models\Order;
use App\Models\OrderExtra;
use App\Models\OrderFood;
use App\Models\UserAddress;
use App\Models\WorkSchedule;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class OrderApiController extends Controller
{
    public function index()
    {
        $orders = OrderResource::collection(Order::currentUser()->with('food')->get());
        return response()->json(compact('orders'));
    }

    public function show($orderId)
    {
        $order = new OrderResource(Order::currentUser()->with('food')->where('id', $orderId)->first());
        if (!$order) {
            abort(404, __("Order Not Found"));
        }
        return response()->json($order);
    }

    public function store(Request $request)
    {
        if (!WorkSchedule::isOpen()) {
            abort(302, __("We are closed today"));
        }

        $data = $request->only(['address_id', 'payment_type', 'payment_details']);

        Validator::make($data, [
            'address_id' => ['required', 'integer', 'min:1'],
            'payment_type' => ['required', Rule::in(['cash', 'cards'])],
            'payment_details' => ['required'],
        ])->validate();

        $user = Auth::user();
        $address = UserAddress::currentUser($user->id)->where('id', $data['address_id'])->first();

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

        $cartTotal = round($cart->map(function ($cartItem) {
            return $cartItem->getTotal($cartItem->food, $cartItem->extras);
        })->sum(), 2);

        switch ($data['payment_type']) {
            case 'cash':
                Validator::make($data['payment_details'], [
                    'value' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
                ])->validate();
                if ($cartTotal > round((float) $data['payment_details']['value'], 2)) {
                    abort(302, __("Value Invalid"));
                }
                break;
            case 'cards':
                Validator::make($data['payment_details'], [
                    'cards' => ['required', 'array'],
                    'cards.*.value' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
                ])->validate();
                if ($cartTotal != round(collect($data['payment_details']['cards'])->sum('value'), 2)) {
                    abort(302, __("Value Invalid"));
                }
                break;
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
            'delivery_fee' => round($deliveryArea->getRawOriginal('price'), 2),
            'payment_type' => $data['payment_type'],
            'payment_details' => json_encode($data['payment_details']),
        ]);

        foreach ($cart as $item) {
            $orderFood = OrderFood::create([
                'order_id' => $order->id,
                'name' => $item->food->name,
                'price' => round($item->food->getRawOriginal('price'), 2),
                'observation' => $item->observation,
                'quantity' => $item->quantity,
            ]);

            if ($item->extras) {
                foreach ($item->extras as $extraItem) {
                    OrderExtra::create([
                        'order_food_id' => $orderFood->id,
                        'name' => $extraItem->extra->name,
                        'quantity' => $extraItem->quantity,
                        'price' => round($extraItem->extra->getRawOriginal('price'), 2),
                    ]);
                }
            }
        }

        Cart::currentUser()->delete();

        return response()->json(["success" => true]);
    }

    public function cancel($orderId)
    {
        $order = Order::currentUser()->where('id', $orderId)->first();

        if (!$order) {
            abort(404, __("Order Not Found"));
        }

        if (!$order->cancelable) {
            abort(404, __("Order Not Cancelable"));
        }

        $order->status = Order::STATUS_CANCELED;
        $order->save();

        return response()->json(["success" => true]);
    }
}
