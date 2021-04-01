<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'end_time'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'weekday' => 'required|min:0|max:6',
        'start_time' => 'required'
    ];

    public function getWeeknameAttribute(){

        $weekNames = [
            'Domingo', 
            'Segunda', 
            'Terça', 
            'Quarta', 
            'Quinta', 
            'Sexta', 
            'Sábado'
        ];

        return $weekNames[$this->weekday];
    }
}
