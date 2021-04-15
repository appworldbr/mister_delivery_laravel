<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Traits\AddressAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressAPIController extends AppBaseController
{
    use AddressAPI;

    public function index()
    {
        return $this->sendResponse(Auth::user()->address, "Endereços carregados com Sucesso");
    }

    public function show($id)
    {
        $address = Auth::user()->address()->where('id', $id)->first();

        if(!$address){
            return $this->sendError("Endereço não encontrado", 404);
        }

        return $this->sendResponse($address, "Endereços carregados com Sucesso");
    }

    public function store(Request $request)
    {
        $data = $request->only(['address_name', 'zip', 'state', 'city', 'district', 'address', 'number', 'complement']);
        $validator = $this->addressValidator($data);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->all(), 400);
        }

        $user = Auth::user();
        $address = $this->createAddress($user, $data);
        if ($request->exists('is_default') && $request->input('is_default')) {
            $this->setDefaultAddress($user, $address);
        }

        return $this->sendResponse($address, 'Endereço criado com sucesso');
    }

    public function update($id, Request $request)
    {
        $data = $request->only(['address_name', 'zip', 'state', 'city', 'district', 'address', 'number', 'complement']);
        $validator = $this->addressValidator($data);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->all(), 400);
        }
        
        $data['name'] = $data['address_name'];
        unset($data['address_name']);

        $user = Auth::user();
        $address = $user->address()->where('id', $id)->first();
        if (!$address) {
            return $this->sendError("Endereço não encontrado", 404);
        }

        $address->update($data);
        
        return $this->sendResponse($address, 'Endereço atualizado com sucesso');
    }

    public function default($id)
    {
        $user = Auth::user();
        $address = $user->address()->where('id', $id)->first();

        if(!$address){
            return $this->sendError("Endereço não encontrado", 404);
        }

        $this->setDefaultAddress($user, $address);
        
        return $this->sendResponse($address, 'Endereço definido como padrão com sucesso');

    }

    public function delete($id)
    {
        $user = Auth::user();
        $address = $user->address()->where('id', $id)->first();

        if(!$address){
            return $this->sendError("Endereço não encontrado", 404);
        }

        if($address->is_default){
            return $this->sendError("Não é possível deletar o endereço padrão", 401);
        }

        $deleted = $address->delete();
        if (!$deleted) {
            return $this->sendError("Erro ao deletar, tente mais tarde", 404);
        }

        return $this->sendSuccess('Endereço deletado com sucesso');
    }
}
