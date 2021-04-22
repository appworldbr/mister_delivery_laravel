<?php

namespace App\Http\Controllers;

use App\Models\DeliveryArea;

class DeliveryAreaController extends Controller
{
    public function index()
    {
        return view('delivery_areas.index', [
            'model' => DeliveryArea::class,
        ]);
    }

    public function form(DeliveryArea $deliveryArea = null)
    {
        return view("delivery_areas.form", compact("deliveryArea"));
    }
}
