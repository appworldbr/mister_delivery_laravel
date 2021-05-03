<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginAPIController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('token_name', 'email', 'password');

        Validator::make($credentials, [
            'token_name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ])->validate();

        $user = User::where('email', $credentials['email'])->first();
        if (!($user && Hash::check($credentials['password'], $user->password))) {
            return response()->json(['messages' => __('User Not Found')], 400);
        }

        $user = User::where('email', $credentials['email'])->first();

        $user->tokens()->where('name', $credentials['token_name'])->delete();
        $token = $user->createToken($credentials['token_name']);

        return response()->json([
            'token' => $token->plainTextToken,
        ]);
    }
}
