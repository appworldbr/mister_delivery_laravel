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
}
