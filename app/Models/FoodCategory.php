<?php

namespace App\Models;

use App\Traits\HasTable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Str;

class FoodCategory extends Model
{
    use HasFactory;
    use HasTable;

    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function defineTable()
    {
        $this->setSortBy('name')
            ->addColumns([
                'name',
                'icon',
            ], ['name']);
    }

    public function getIconAttribute($value)
    {
        return __(Str::title($value));
    }
}
