<?php

namespace App\Models;

use App\Traits\HasTable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DayOff extends Model
{
    use HasFactory, HasTable;

    protected $guarded = [];

    public function defineTable()
    {
        $this->addColumns(['day', 'start', 'end'])->isSearchable(false);
    }

    public function getDayAttribute($value)
    {
        return (new Carbon($value))->format('d/m/Y');
    }

    public function getStartAttribute($value)
    {
        return Carbon::createFromFormat('H:i:s', $value)->format('H:i');
    }

    public function setStartAttribute($value)
    {
        $this->attributes['start'] = Carbon::createFromFormat('H:i', $value)->format('H:i:s');
    }

    public function getEndAttribute($value)
    {
        return Carbon::createFromFormat('H:i:s', $value)->format('H:i');
    }

    public function setEndAttribute($value)
    {
        $this->attributes['end'] = Carbon::createFromFormat('H:i', $value)->format('H:i:s');
    }
}
