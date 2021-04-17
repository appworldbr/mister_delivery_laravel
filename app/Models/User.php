<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\HasTable;
use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;
    use HasTable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function defineTable()
    {
        $this->setSortBy('name')
            ->addColumns(['name', 'email', 'rolesInStr'], ['name'])
            ->addColumnName('rolesInStr', 'roles');
    }

    public function getDeletable($user = null)
    {
        if ($user && $user->hasRole('admin')) {
            return false;
        }

        if ($this->id) {
            return Auth::id() !== $this->id;
        }

        return $this->deletable;
    }

    public function getRolesInStrAttribute()
    {
        $rolesNames = $this->getRoleNames();
        if (count($rolesNames)) {
            return $this->getRoleNames()->implode(', ');
        }
        return '-';
    }
}
