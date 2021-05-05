<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Auth;

class UserApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'user' => Auth::user()->with('address')->with('telephones')->get(),
        ]);
    }
}
