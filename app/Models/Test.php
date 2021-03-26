<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use AhmedAliraqi\LaravelMediaUploader\Entities\Concerns\HasUploader;

/**
 * Class Test
 * @package App\Models
 * @version March 26, 2021, 5:21 pm UTC
 *
 * @property string $name
 */
class Test extends Model implements HasMedia
{
    use SoftDeletes;
    use InteractsWithMedia, HasUploader;
    use HasFactory;

    public $table = 'tests';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'max:27'
    ];

    
}
