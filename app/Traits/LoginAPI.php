<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

trait LoginAPI
{
    private function loginValidator($data)
    {
        $validator = Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ], [], [
            'email' => 'E-mail',
            'password' => 'Senha',
        ]);

        return $validator;
    }

    private function loginVerification($credentials)
    {
        $user = User::where('email', $credentials['email'])->first();
        return $user && Hash::check($credentials['password'], $user->password);
    }
}
