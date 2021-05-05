<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        return view("orders.index", [
            'model' => Order::class,
        ]);
    }

    public function form(Order $order = null)
    {
        return view("orders.form", compact("order"));
    }
}
