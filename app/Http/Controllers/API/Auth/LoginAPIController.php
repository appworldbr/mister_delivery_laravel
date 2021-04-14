<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\AppBaseController;
use App\Models\User;
use App\Traits\LoginAPI;
use App\Traits\TokenAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginAPIController extends AppBaseController
{
    use LoginAPI, TokenAPI;
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

        return $this->sendResponse([
            'token' => $token->plainTextToken,
        ], 'Usuário logado com sucesso');
    }
}
