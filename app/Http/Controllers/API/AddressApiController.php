<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AddressAPIController extends Controller
{
    public function index()
    {
        $address = Auth::user()->address;
        return response()->json(compact('address'));
    }

    public function show($id)
    {
        $address = UserAddress::currentUser()->where('id', $id)->first();

        if (!$address) {
            abort(404, __("Address Not Found"));
        }

        return response()->json(compact('address'));
    }

    public function store(Request $request)
    {
        $data = $request->only(['name', 'zip', 'state', 'city', 'district', 'address', 'number', 'complement']);

        Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'zip' => ['required', 'string', 'size:8'],
            'state' => ['required', 'string', 'size:2'],
            'city' => ['required', 'string', 'max:100'],
            'district' => ['required', 'string', 'max:100'],
            'address' => ['required', 'string', 'max:255'],
            'number' => ['required', 'string', 'max:100'],
            'complement' => ['nullable', 'string', 'max:100'],
        ])->validate();

        $data['user_id'] = Auth::id();
        $data['is_default'] = false;

        $address = UserAddress::create($data);

        return response()->json(compact('address'));
    }

    public function update($id, Request $request)
    {
        $data = $request->only(['name', 'zip', 'state', 'city', 'district', 'address', 'number', 'complement']);

        Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'zip' => ['required', 'string', 'size:8'],
            'state' => ['required', 'string', 'size:2'],
            'city' => ['required', 'string', 'max:100'],
            'district' => ['required', 'string', 'max:100'],
            'address' => ['required', 'string', 'max:255'],
            'number' => ['required', 'string', 'max:100'],
            'complement' => ['nullable', 'string', 'max:100'],
        ])->validate();

        $address = UserAddress::currentUser()->where('id', $id)->first();

        if (!$address) {
            abort(404, __('Address Not Found'));
        }

        $address->update($data);

        return response()->json(compact('address'));
    }

    public function setDefault($id)
    {
        $address = UserAddress::setDefault($id);
        if (!$address) {
            abort(404, __('Address Not Found'));
        }
        return response()->json(compact('address'));
    }

    public function delete($id)
    {
        $address = UserAddress::currentUser()->where('id', $id)->first();

        if (!$address) {
            abort(404, __('Address Not Found'));
        }

        if ($address->is_default) {
            abort(302, __('Address Is Default'));
        }

        $address->delete();

        return response()->json(["success" => true]);
    }
}
