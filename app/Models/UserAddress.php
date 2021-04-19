<?php

namespace App\Models;

use Auth;
use Http;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class UserAddress extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
        'user_id',
    ];

    public function setZipAttribute($value)
    {
        $this->attributes['zip'] = preg_replace('/[^0-9]/', '', $value);
    }

    public function getZipAttribute($value)
    {
        return preg_replace('/([0-9]{5})([0-9]{3})/', '$1-$2', $value);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getZipInformation($zip)
    {
        $response = Http::get("https://viacep.com.br/ws/$zip/json/");
        if ($response->successful()) {
            return $response->json();
        }
        return [];
    }

    public static function validator($data)
    {
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
    }

    public static function get($id, $user = null)
    {
        if (!$user) {
            $user = Auth::user();
        }
        return $user->address()->where('id', $id)->first();
    }

    public static function add($input, $user = null)
    {
        if (!$user) {
            $user = Auth::user();
        }

        return static::create(array_merge($input, ['user_id' => $user->id]));
    }

    public static function remove($id, $user = null)
    {
        if (!$user) {
            $user = Auth::user();
        }

        $address = $user->address()->where('id', $id)->first();

        if (!$address) {
            return false;
        }

        if ($address->is_default) {
            return false;
        }

        return $address->delete();
    }

    public static function setDefault($id, $user = null)
    {
        if (!$user) {
            $user = Auth::user();
        }
        $address = $user->address->where('id', $id)->first();

        if (!$address) {
            return false;
        }

        $user->address()->update([
            'is_default' => false,
        ]);

        $address->update([
            'is_default' => true,
        ]);

        return $address;
    }
}
