<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        return view("users.index", [
            'model' => User::class,
        ]);
    }

    public function form(User $user = null)
    {
        return view("users.form", compact("user"));
    }
}
