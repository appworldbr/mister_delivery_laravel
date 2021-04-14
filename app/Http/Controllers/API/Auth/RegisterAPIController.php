<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\AppBaseController;
use App\Traits\AddressAPI;
use App\Traits\RegisterApi;
use App\Traits\TokenAPI;
use Illuminate\Http\Request;

class RegisterAPIController extends AppBaseController
{
    use RegisterApi, AddressAPI, TokenAPI;

    public function create(Request $request)
    {
        $userData = $request->only(['name', 'email', 'password']);
        $userAddressData = $request->only(['address_name', 'zip', 'state', 'city', 'district', 'address', 'number', 'complement']);

        $validator = $this->registerValidator($userData);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->all(), 400);
        }

        $addressValidator = $this->addressValidator($userAddressData);
        if ($addressValidator->fails()) {
            return $this->sendError($addressValidator->errors()->all(), 400);
        }

        $user = $this->createUser($userData);
        $this->createAddress($user, $userAddressData, true);

        $token = $this->createToken($user);

        return $this->sendResponse([
            'token' => $token->plainTextToken,
        ], 'Usuário criado com sucesso');
    }

}
