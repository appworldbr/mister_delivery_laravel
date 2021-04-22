<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressAPIController extends Controller
{
    public function index()
    {
        $address = Auth::user()->address;
        return response()->json(compact('address'));
    }

    public function show($id)
    {
        $address = UserAddress::get($id);

        if (!$address) {
            return response()->json(["errors" => __("Address Not Found")], 404);
        }

        return response()->json(compact('address'));
    }

    public function store(Request $request)
    {
        $data = $request->only(['name', 'zip', 'state', 'city', 'district', 'address', 'number', 'complement']);

        UserAddress::validator($data);
        $address = UserAddress::add($data);

        if ($request->exists('is_default') && $request->input('is_default')) {
            UserAddress::setDefault($address->id);
        }

        return response()->json(compact('address'));
    }

    public function update($id, Request $request)
    {

        $data = $request->only(['name', 'zip', 'state', 'city', 'district', 'address', 'number', 'complement']);

        UserAddress::validator($data);
        $address = UserAddress::get($id);

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
        if (!UserAddress::remove($id)) {
            abort(404, __('Address Not Found'));
        }

        return response()->json(["success" => true]);
    }
}
