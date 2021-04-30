<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function ordersOfTheDay()
    {
        return view('orders-of-the-day.index');
    }
}
