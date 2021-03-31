<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class WorkSchedule
 * @package App\Models
 * @version March 31, 2021, 8:55 pm UTC
 *
 * @property string $weekday
 * @property number $start-time
 * @property number $end_time
 */
class WorkSchedule extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'work_schedules';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'weekday',
        'start-time',
        'end_time'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'weekday' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'weekday' => 'required|max:20',
        'start-time' => 'required|max:4',
        'end_time' => 'required'
    ];

    
}
