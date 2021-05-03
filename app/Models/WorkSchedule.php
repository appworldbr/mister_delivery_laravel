<?php

namespace App\Models;

use App\Traits\HasTable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkSchedule extends Model
{
    use HasFactory, HasTable;

    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function defineTable()
    {
        $this->setSortBy('weekday')
            ->addColumns([
                'weekday',
                'start',
                'end',
            ], [
                'weekday',
            ])
            ->isSearchable(false);
    }

    public function scopeTable($query, $paginate, $sortBy, $sortDirection, $search = '')
    {
        return $query->ordered($sortBy, $sortDirection)->paginate($paginate);
    }

    public function scopeOrdered($query, $sortBy = "weekday", $sortDirection = "asc")
    {
        return $query->orderBy($sortBy, $sortDirection)->orderBy('id');
    }

    public function getWeekdayAttribute($value)
    {
        return [
            __("Sunday"),
            __("Monday"),
            __("Tuesday"),
            __("Wednesday"),
            __("Thursday"),
            __("Friday"),
            __("Saturday"),
        ][$value];
    }

    public function getStartAttribute($value)
    {
        return Carbon::createFromFormat('H:i:s', $value)->format('H:i');
    }

    public function setStartAttribute($value)
    {
        $this->attributes['start'] = Carbon::createFromFormat('H:i', $value)->format('H:i:s');
    }

    public function setEndAttribute($value)
    {
        $this->attributes['end'] = Carbon::createFromFormat('H:i', $value)->format('H:i:s');
    }

    public function getEndAttribute($value)
    {
        return Carbon::createFromFormat('H:i:s', $value)->format('H:i');
    }

    public function scopeIsOpen($query, $weekday = null, $time = null)
    {
        if ($weekday == null) {
            $weekday = date('w');
        }

        if ($time == null) {
            $time = date('H:i');
        }

        return $query->where('weekday', $weekday)
            ->whereTime('start', '<=', $time)
            ->whereTime('end', '>', $time)
            ->exists();
    }

    public function scopeNextTimeOpen($query, $weekday = null, $time = null)
    {
        if ($weekday == null) {
            $weekday = date('w');
        }

        if ($time == null) {
            $time = date('H:i');
        }

        $nextTimeOpen = $query->where(function ($query) use ($weekday, $time) {
            $query->where('weekday', $weekday)
                ->where('start', '>=', $time);
        })->Orwhere(function ($query) use ($weekday) {
            $query->where('weekday', '>', $weekday);
        })->orderBy('weekday')
            ->orderBy('start')
            ->firstOr(function () {
                return self::orderBy('weekday')->orderBy('start')->first();
            });

        if (!$nextTimeOpen) {
            return false;
        }

        return [
            'weekday' => $nextTimeOpen->weekday,
            'nextHour' => $nextTimeOpen->start,
        ];
    }
}
