<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const STATUS_CANCELED = 0;
    const STATUS_CONCLUDED = 1;
    const STATUS_WAITING = 2;
    const STATUS_PREPARATION = 3;
    const STATUS_DELIVERY = 4;

    use HasFactory;

    protected $guarded = [];

    public function scopeCurrentUser($query, $userId = null)
    {
        return $query->where('user_id', $userId ?? Auth::id());
    }
}
