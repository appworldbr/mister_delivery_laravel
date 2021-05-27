<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginAPIController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        Validator::make($credentials, [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ])->validate();

        if (!Auth::attempt($credentials)) {
            abort(403, trans('auth.failed'));
        }

        $request->session()->regenerate();

        return response()->json(true);
    }
}
