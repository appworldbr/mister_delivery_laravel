<?php

namespace App\Models;

use App\ModelTable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkSchedule extends ModelTable
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    static $sortBy = 'weekday';

    static $columns = [
        'id',
        'weekday',
        'start',
        'finish',
    ];

    static $sortableColumns = [
        'weekday',
    ];

    static $searchable = false;

    public static function table($paginate, $sortBy, $sortDirection, $search = '')
    {
        return static::ordered($sortBy, $sortDirection)->paginate($paginate);
    }

    public static function getFormRoute($id = null)
    {
        if (!$id) {
            return route('workSchedule.form');
        }
        return route('workSchedule.form', [
            'workSchedule' => $id,
        ]);
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

    public function setFinishAttribute($value)
    {
        $this->attributes['finish'] = Carbon::createFromFormat('H:i', $value)->format('H:i:s');
    }

    public function getFinishAttribute($value)
    {
        return Carbon::createFromFormat('H:i:s', $value)->format('H:i');
    }

    public function scopeOrdered($query, $sortBy = "weekday", $sortDirection = "asc")
    {
        return $query->orderBy($sortBy, $sortDirection)->orderBy('id');
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
            ->whereTime('finish', '>', $time)
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
