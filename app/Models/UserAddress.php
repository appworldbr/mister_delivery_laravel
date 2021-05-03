<?php

namespace App\Models;

use Auth;
use Http;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
        'user_id',
    ];

    public function scopeCurrentUser($query, $userId = null)
    {
        return $query->where('user_id', $userId ?? Auth::id());
    }

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

    public static function setDefault($id, $user = null)
    {
        if (!$user) {
            $user = Auth::user();
        }
        $address = $user->address->where('id', $id)->first();

        if (!$address) {
            abort(404, __('Address Not Found'));
        }

        if ($address->is_default) {
            abort(302, __('Address Is Already The Default'));
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
