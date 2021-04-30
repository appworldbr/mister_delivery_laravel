<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderFood extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;

    public function extras()
    {
        return $this->hasMany(OrderExtra::class);
    }

    public function getTotal($extras)
    {
        $foodExtra = $extras->map(function ($extraItem) {
            return $extraItem->quantity * (float) $extraItem->getRawOriginal('price');
        })->sum();
        return round($this->quantity * (float) $this->getRawOriginal('price') + $foodExtra, 2);
    }
}
