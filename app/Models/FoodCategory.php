<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class FoodCategory
 * @package App\Models
 * @version April 6, 2021, 7:05 pm UTC
 *
 * @property string $name
 * @property string $description
 * @property boolean $has_details
 */
class FoodCategory extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'food_categories';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'description',
        'has_details'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'description' => 'string',
        'has_details' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|max:127',
        'description' => 'max:10000'
    ];

    public function getHasDetailsAttribute(){
        return $this->has_details?'Sim':'Não';
    }

    
}
