<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class LoginAPIController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('token_name', 'email', 'password');

        User::apiLoginValidator($credentials);

        if (!User::apiLoginVerification($credentials)) {
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
