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

    protected static function booted()
    {
        static::deleting(function ($foodCategory) {
            foreach ($foodCategory->food as $food) {
                $food->delete();
            }
        });
    }

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

    public function food()
    {
        return $this->hasMany(Food::class, 'category_id')->active();
    }

    public function extras()
    {
        return $this->hasMany(FoodExtra::class, 'category_id')->active();
    }
}
