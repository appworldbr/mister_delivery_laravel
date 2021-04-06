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
        'start_time' => 'required|date_format:G:i',
        'end_time' => 'required|date_format:G:i'
    ];

    public function getWeeknameAttribute(){

        $weekNames = [
            'Domingo', 
            'Segunda-feira', 
            'Terça-feira', 
            'Quarta-feira', 
            'Quinta-feira', 
            'Sexta-feira', 
            'Sábado'
        ];

        return $weekNames[$this->weekday];
    }
     public static function isOpen(){
        //@TODO fazer a logica para sempre o campo de end_time ser maior que o de start_time
     }
}
