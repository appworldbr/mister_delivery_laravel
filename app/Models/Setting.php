<?php

namespace App\Models;

use AhmedAliraqi\LaravelMediaUploader\Entities\Concerns\HasUploader;
use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * Class Setting
 * @package App\Models
 * @version March 26, 2021, 7:02 pm UTC
 *
 * @property string $key
 * @property string $value
 */
class Setting extends Model implements HasMedia
{
    use SoftDeletes;
    use InteractsWithMedia;
    use HasUploader;

    use HasFactory;

    public $table = 'settings';
    public $timestamps = false;

    protected $dates = ['deleted_at'];



    public $fillable = [
        'key',
        'value'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'key' => 'string',
        'value' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
