<?php

namespace App\Models;

use App\Traits\HasImage;
use App\Traits\HasPrice;
use App\Traits\HasTable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;
    use HasTable;
    use HasPrice;
    use HasImage;

    protected $guarded = [];

    public function defineTable()
    {
        $this->addColumns([
            'name',
            'price',
            'active',
        ]);
    }

    public function getActiveAttribute($value)
    {
        return $value ? __("Yes") : __("No");
    }
}
