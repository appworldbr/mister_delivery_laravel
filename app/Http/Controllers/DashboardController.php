<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $currentMonth = Carbon::now()->format('m');
        $quantityCount = Order::whereMonth('created_at', $currentMonth)->count();
        $priceTotal = Order::with('food')->whereMonth('created_at', $currentMonth)->where('status', Order::STATUS_CONCLUDED)->get()->sum(function ($order) {
            return $order->getTotal($order->food);
        });
        $clientCount = User::role('client')->whereMonth('created_at', $currentMonth)->count();

        return view('dashboard', [
            'quantityCount' => $quantityCount,
            'priceTotal' => $priceTotal,
            'clientCount' => $clientCount,
        ]);
    }

    public function ordersOfTheDay()
    {
        return view('orders_of_the_day.index');
    }
}
