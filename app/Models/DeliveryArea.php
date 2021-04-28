<?php

namespace App\Models;

use App\Traits\HasPrice;
use App\Traits\HasTable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryArea extends Model
{
    use HasFactory;
    use HasTable;
    use HasPrice;

    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function defineTable()
    {
        $this->setSortBy('initial')
            ->addColumns([
                'initial',
                'final',
                'price',
                'prevent',
            ])
            ->isSearchable(false);
    }

    public function getInitialAttribute($value)
    {
        return preg_replace('/([0-9]{5})([0-9]{3})/', '$1-$2', $value);
    }

    public function getFinalAttribute($value)
    {
        return preg_replace('/([0-9]{5})([0-9]{3})/', '$1-$2', $value);
    }

    public function getPreventAttribute($value)
    {
        return $value ? __("Yes") : __("No");
    }

    public function scopeValidationZip($query, $zip)
    {
        $area = $query->where('initial', '<=', $zip)
            ->where('final', '>=', $zip)
            ->orderBy('prevent', 'desc')
            ->orderBy('initial', 'desc')
            ->orderBy('final', 'desc')
            ->first();

        if ($area && !$area->getRawOriginal('prevent')) {
            return $area;
        }

        return false;
    }
}
