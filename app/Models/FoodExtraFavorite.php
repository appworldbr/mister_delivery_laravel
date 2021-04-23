<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodExtraFavorite extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;

    public function extra()
    {
        return $this->belongsTo(FoodExtra::class, 'extra_id');
    }
}
