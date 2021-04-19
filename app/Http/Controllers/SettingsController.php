<?php

namespace App\Http\Controllers;

class SettingsController extends Controller
{
    public function form()
    {
        return view("settings.form");
    }
}
