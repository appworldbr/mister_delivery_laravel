<?php

namespace App\Models;

use App\Traits\HasPrice;
use App\Traits\HasTable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodExtra extends Model
{
    use HasFactory;
    use HasTable;
    use HasPrice;

    protected $guarded = [];

    public function defineTable()
    {
        $this->addSearchFields(['name', 'categoryName'])
            ->setSortBy('name')
            ->addColumns([
                'name',
                'categoryName',
                'price',
                'limit',
                'active',
            ], ['name'])
            ->addColumnName('categoryName', 'category');
    }

    public function getActiveAttribute($value)
    {
        return $value ? __("Yes") : __("No");
    }

    public function getCategoryNameAttribute()
    {
        return $this->category->name;
    }

    public function scopeTable($query, $paginate, $sortBy, $sortDirection, $search = '')
    {
        foreach ($this->searchFields as $searchField) {
            if ($searchField == 'categoryName') {
                $query->orWhereHas('category', function ($query) use ($search) {
                    $query->where('name', 'like', "%$search%");
                });
            } else {
                $query = $query->orWhere($searchField, 'like', "%$search%");
            }
        }
        return $query->orderBy($sortBy, $sortDirection)->paginate($paginate);
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function category()
    {
        return $this->belongsTo(FoodCategory::class, 'category_id');
    }
}
