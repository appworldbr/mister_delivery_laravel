<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class DeliveryArea
 * @package App\Models
 * @version April 6, 2021, 3:21 pm UTC
 *
 * @property string $initial_zip
 * @property string $final_zip
 * @property number $price
 * @property boolean $prevent
 */
class DeliveryArea extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'delivery_areas';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'initial_zip',
        'final_zip',
        'price',
        'prevent',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'initial_zip' => 'string',
        'final_zip' => 'string',
        'price' => 'decimal:2',
        'prevent' => 'boolean',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'initial_zip' => 'required|max:9',
        'final_zip' => 'required|max:9',
        'price' => 'nullable',

    ];

    public function getIsPreventAttribute()
    {
        return $this->prevent ? 'Sim' : 'Não';
    }

    public function ValidationZip($zip)
    {
        $area = DeliveryArea::where('initial_zip', '<=', $zip)
            ->where('final_zip', '>=', $zip)
            ->orderBy('prevent', 'desc')
            ->orderBy('initial_zip', 'desc')
            ->orderBy('final_zip', 'desc')
            ->first();

        if ($area && $area->prevent) {
            return false;
        }
        return $area;
    }

}
