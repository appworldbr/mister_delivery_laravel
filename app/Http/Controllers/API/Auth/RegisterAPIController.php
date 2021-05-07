<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserTelephone;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterAPIController extends Controller
{
    public function create(Request $request)
    {
        $userData = $request->only(['token_name', 'name', 'email', 'password']);
        $userAddressData = $request->only(['address_name', 'zip', 'state', 'city', 'district', 'address', 'number', 'complement']);
        $userTelephoneData = $request->only(['telephone']);

        $userAddressData['name'] = $userAddressData['address_name'];
        unset($userAddressData['address_name']);

        Validator::make($userData, [
            'token_name' => ['required', 'string', 'max:50'],
            'name' => ['required', 'string', 'max: 255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ])->validate();

        Validator::make($userAddressData, [
            'name' => ['required', 'string', 'max:255'],
            'zip' => ['required', 'string', 'size:8'],
            'state' => ['required', 'string', 'size:2'],
            'city' => ['required', 'string', 'max:100'],
            'district' => ['required', 'string', 'max:100'],
            'address' => ['required', 'string', 'max:255'],
            'number' => ['required', 'string', 'max:100'],
            'complement' => ['nullable', 'string', 'max:100'],
        ])->validate();

        Validator::make($userTelephoneData, [
            'telephone' => ['required', 'string', 'min:10', 'max:11'],
        ])->validate();

        $user = User::create([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => Hash::make($userData['password']),
        ]);

        $user->assignRole('client');

        $userAddressData['user_id'] = $user->id;
        $userAddressData['is_default'] = true;
        UserAddress::create($userAddressData);

        $userTelephoneData['user_id'] = $user->id;
        $userTelephoneData['is_default'] = true;
        UserTelephone::create($userTelephoneData);

        $user->tokens()->where('name', $userData['token_name'])->delete();
        $token = $user->createToken($userData['token_name']);

        return response()->json([
            'token' => $token->plainTextToken,
        ]);
    }

}
