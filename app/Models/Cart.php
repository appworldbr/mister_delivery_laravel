<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;

    public function scopeCurrentUser($query, $userId = null)
    {
        return $query->where('user_id', $userId ?? Auth::id());
    }

    public function food()
    {
        return $this->belongsTo(Food::class);
    }

    public function extras()
    {
        return $this->hasMany(CartExtra::class, 'cart_id')->with('extra');
    }

    public function getTotal($food, $extras)
    {
        $foodSum = $this->quantity * (float) $food->getRawOriginal('price');
        $extraSum = $extras->map(function ($extraItem) {
            return $extraItem->quantity * (float) $extraItem->extra->getRawOriginal('price');
        })->sum();
        return round($foodSum + $extraSum, 2);
    }
}
