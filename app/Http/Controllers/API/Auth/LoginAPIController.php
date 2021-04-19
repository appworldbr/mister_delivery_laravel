<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\LoginAPI;
use App\Traits\TokenAPI;
use Illuminate\Http\Request;

class LoginAPIController extends Controller
{
    use LoginAPI;
    use TokenAPI;
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $validator = $this->loginValidator($credentials);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->all(), 400);
        }

        if (!$this->loginVerification($credentials)) {
            return $this->sendError(["E-mail e/ou Senha incorretos"], 400);
        }

        $user = User::where('email', $credentials['email'])->first();
        $token = $this->regenerateToken($user);

        return response()->json([
            'token' => $token->plainTextToken,
        ]);
    }
}
