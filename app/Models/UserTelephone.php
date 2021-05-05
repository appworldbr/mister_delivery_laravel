<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTelephone extends Model
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

    public function setTelephoneAttribute($value)
    {
        $this->attributes['telephone'] = preg_replace('/[^0-9]/', '', $value);
    }

    public function getTelephoneAttribute($value)
    {
        return strlen($value) >= 11
        ? preg_replace('/([0-9]{2})([0-9]{1})([0-9]{4})([0-9]{4})/', '($1) $2 $3-$4', $value)
        : preg_replace('/([0-9]{2})([0-9]{4})([0-9]{4})/', '($1) $2-$3', $value);
    }

    public static function setDefault($id, $user = null)
    {
        if (!$user) {
            $user = Auth::user();
        }
        $telephone = $user->telephones->where('id', $id)->first();

        if (!$telephone) {
            abort(404, __('Telephone Not Found'));
        }

        if ($telephone->is_default) {
            abort(302, __('Telephone Is Already The Default'));
        }

        $user->telephones()->update([
            'is_default' => false,
        ]);

        $telephone->update([
            'is_default' => true,
        ]);

        return $telephone;
    }
}
