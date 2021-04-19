<?php

namespace App\Traits;

use App\Models\UserAddress;
use Illuminate\Support\Facades\Validator;

trait AddressAPI
{

    private function addressValidator($data)
    {
        $validator = Validator::make($data, [
            'address_name' => ['required', 'string', 'max:255'],
            'zip' => ['required', 'string', 'size:8'],
            'state' => ['required', 'string', 'size:2'],
            'city' => ['required', 'string', 'max:100'],
            'district' => ['required', 'string', 'max:100'],
            'address' => ['required', 'string', 'max:255'],
            'number' => ['required', 'string', 'max:100'],
            'complement' => ['nullable', 'string', 'max:100'],
        ]);

        return $validator;
    }

    private function createAddress($user, $data, $default = false)
    {
        return UserAddress::create([
            'name' => $data['address_name'],
            'zip' => $data['zip'],
            'state' => $data['state'],
            'city' => $data['city'],
            'district' => $data['district'],
            'address' => $data['address'],
            'number' => $data['number'],
            'complement' => $data['complement'],
            'is_default' => $default,
            'user_id' => $user->id,
        ]);
    }

    private function setDefaultAddress($user, $address)
    {
        $user->address()->update(['is_default' => false]);
        $address->is_default = true;
        $address->save();
    }
}
