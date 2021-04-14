<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Traits\AddressAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAPIController extends AppBaseController
{
    use AddressAPI;

    public function getAddress()
    {
        return $this->sendResponse(Auth::user()->address, "Endereços carregados com Sucesso");
    }

    public function storeAddress(Request $request)
    {
        $data = $request->only(['address_name', 'zip', 'state', 'city', 'district', 'address', 'number', 'complement']);
        $validator = $this->addressValidator($data);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->all(), 400);
        }
        $address = $this->createAddress(Auth::user(), $data);
        return $this->sendResponse($address, 'Endereço criado com sucesso');
    }

    public function updateAddress($id, Request $request)
    {
        $user = Auth::user();
        $address = $user->address()->where('id', $id)->first();
        if (!$address) {
            return $this->sendError(["Endereço não encontrado"], 404);
        }
        dd($request->all());
    }

    public function deleteAddress($id)
    {
        $user = Auth::user();
        $deleted = $user->address()->where('id', $id)->delete();
        if (!$deleted) {
            return $this->sendError(["Endereço não encontrado"], 404);
        }
        return $this->sendResponse(["Endereço deletado com sucesso"], 'Endereço deletado com sucesso');
    }
}
