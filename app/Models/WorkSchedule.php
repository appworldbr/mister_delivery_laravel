<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class WorkSchedule
 * @package App\Models
 * @version April 1, 2021, 7:04 pm UTC
 *
 * @property tinyInteger $weekday
 * @property time $start_time
 * @property time $end_time
 */
class WorkSchedule extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'work_schedules';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'weekday',
        'start_time',
        'end_time',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'weekday' => 'required|min:0|max:6',
        'start_time' => 'required|date_format:G:i',
        'end_time' => 'required|date_format:G:i',
    ];

    public function getWeeknameAttribute()
    {

        $weekNames = [
            'Domingo',
            'Segunda-feira',
            'Terça-feira',
            'Quarta-feira',
            'Quinta-feira',
            'Sexta-feira',
            'Sábado',
        ];

        return $weekNames[$this->weekday];
    }
    public static function isOpen($weekday = null, $time = null)
    {
        if ($weekday == null) {
            $weekday = date('w');
        }
        if ($time == null) {
            $time = date('H:i');
        }
        return self::where('weekday', $weekday)
            ->whereTime('start_time', '<=', $time)
            ->whereTime('end_time', '>', $time)
            ->exists();
    }
    public static function nextTimeOpen($weekday = null, $time = null)
    {
        if ($weekday == null) {
            $weekday = date('w');
        }

        if ($time == null) {
            $time = date('H:i');
        }

        $nextTimeOpen = self::where(function ($query) use ($weekday, $time) {
            $query->where('weekday', $weekday)
                ->where('start_time', '>=', $time);
        })->Orwhere(function ($query) use ($weekday) {
            $query->where('weekday', '>', $weekday);
        })->orderBy('weekday')
            ->orderBy('start_time')
            ->firstOr(function () {
                return self::orderBy('weekday')->orderBy('start_time')->first();
            }
            );

        if (!$nextTimeOpen) {
            return false;
        }

        return [
            'weekname' => $nextTimeOpen->weekname,
            'next_hour' => (new Carbon($nextTimeOpen->start_time))->format('H:i'),
        ];
    }
}
