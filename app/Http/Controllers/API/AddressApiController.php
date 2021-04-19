<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Traits\AddressAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressAPIController extends Controller
{
    use AddressAPI;

    public function index()
    {
        $address = Auth::user()->address;
        return response()->json(compact('address'));
    }

    public function show($id)
    {
        $address = Auth::user()->address()->where('id', $id)->first();

        if (!$address) {
            return response()->json(["errors" => __("Address Not Found")], 404);
        }

        return response()->json(compact('address'));
    }

    public function store(Request $request)
    {
        $data = $request->only(['address_name', 'zip', 'state', 'city', 'district', 'address', 'number', 'complement']);
        $validator = $this->addressValidator($data);
        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()->all()], 400);
        }

        $user = Auth::user();
        $address = $this->createAddress($user, $data);
        if ($request->exists('is_default') && $request->input('is_default')) {
            $this->setDefaultAddress($user, $address);
        }

        return response()->json(compact('address'));
    }

    public function update($id, Request $request)
    {
        $data = $request->only(['address_name', 'zip', 'state', 'city', 'district', 'address', 'number', 'complement']);
        $validator = $this->addressValidator($data);
        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), 400);
        }

        $data['name'] = $data['address_name'];
        unset($data['address_name']);

        $user = Auth::user();
        $address = $user->address()->where('id', $id)->first();
        if (!$address) {
            return response()->json(["errors" => __("Address Not Found")], 404);
        }

        $address->update($data);

        return response()->json(compact('address'));
    }

    function default($id) {
        $user = Auth::user();
        $address = $user->address()->where('id', $id)->first();

        if (!$address) {
            return response()->json(["errors" => __("Address Not Found")], 404);
        }

        $this->setDefaultAddress($user, $address);

        return response()->json(compact('address'));

    }

    public function delete($id)
    {
        $user = Auth::user();
        $address = $user->address()->where('id', $id)->first();

        if (!$address) {
            return response()->json(["errors" => __("Address Not Found")], 404);
        }

        if ($address->is_default) {
            return response()->json(["errors" => __("It is not possible to delete the default address")], 401);
        }

        $deleted = $address->delete();
        if (!$deleted) {
            return response()->json(["errors" => __("Error Not Found, Try Again Later")], 404);
        }

        return response()->json(["success" => true]);
    }
}
