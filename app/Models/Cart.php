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

    public function scopeCurrentUser($query)
    {
        return $query->where('user_id', Auth::id());
    }

    public function food()
    {
        return $this->belongsTo(Food::class);
    }

    public function extras()
    {
        return $this->hasMany(CartExtra::class, 'cart_id')->with('extra');
    }
}
