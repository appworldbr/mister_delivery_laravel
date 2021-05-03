<?php

namespace App\Http\Controllers;

use App\Models\DayOff;

class DayOffController extends Controller
{
    public function index()
    {
        return view("day_off.index", [
            'model' => DayOff::class,
        ]);
    }

    public function form(DayOff $dayOff = null)
    {
        return view("day_off.form", compact("dayOff"));
    }
}
