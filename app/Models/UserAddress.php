<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class UserAddress
 * @package App\Models
 * @version March 30, 2021, 6:55 pm UTC
 *
 * @property string $name
 * @property string $zip
 * @property string $state
 * @property string $city
 * @property string $district
 * @property string $address
 * @property string $number
 * @property string $complement
 * @property boolean $is_default
 * @property foreignId $use_id
 */
class UserAddress extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'user_addresses';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'zip',
        'state',
        'city',
        'district',
        'address',
        'number',
        'complement',
        'is_default',
        'use_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'zip' => 'string',
        'state' => 'string',
        'city' => 'string',
        'district' => 'string',
        'address' => 'string',
        'number' => 'string',
        'complement' => 'string',
        'is_default' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|max:127',
        'zip' => 'required|regex:/[0-9]{5}-[0-9]{3}/',
        'state' => 'required|max:2',
        'city' => 'required|max:100',
        'district' => 'required|max:127',
        'address' => 'required|max:127',
        'number' => 'required|max:127',
        'complement' => 'nullable|max:127',
        'is_default' => 'boolean'
    ];

    
}
