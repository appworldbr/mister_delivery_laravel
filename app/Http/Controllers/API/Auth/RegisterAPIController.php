<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserAddress;
use Hash;
use Illuminate\Http\Request;

class RegisterAPIController extends Controller
{
    public function create(Request $request)
    {
        $userData = $request->only(['token_name', 'name', 'email', 'password']);
        $userAddressData = $request->only(['address_name', 'zip', 'state', 'city', 'district', 'address', 'number', 'complement']);

        $userAddressData['name'] = $userAddressData['address_name'];
        unset($userAddressData['address_name']);

        User::apiRegisterValidator($userData);
        UserAddress::validator($userAddressData);

        $user = User::create([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => Hash::make($userData['password']),
        ]);

        $userAddressData['user_id'] = $user->id;
        $userAddressData['is_default'] = true;

        UserAddress::create($userAddressData);

        $user->tokens()->where('name', $userData['token_name'])->delete();
        $token = $user->createToken($userData['token_name']);

        return response()->json([
            'token' => $token->plainTextToken,
        ]);
    }

}
