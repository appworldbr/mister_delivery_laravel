<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
    use HasFactory;

    public $table = 'delivery_areas';

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
        'price' => 'float',
        'prevent' => 'boolean',
    ];

    public static function getRules($id = null)
    {
        $initialZipRuleUnique = 'unique:delivery_areas,initial_zip';
        if ($id) {
            $initialZipRuleUnique .= ",$id";
        }

        $finalZipRuleUnique = 'unique:delivery_areas,final_zip';
        if ($id) {
            $finalZipRuleUnique .= ",$id";
        }

        return [
            'initial_zip' => "required|max:9|lte:final_zip|$initialZipRuleUnique",
            'final_zip' => "required|max:9|gte:initial_zip|$finalZipRuleUnique",
            'price' => 'nullable',
        ];
    }

    public function getIsPreventAttribute()
    {

        return $this->prevent ? 'Sim' : 'Não';
    }

    public static function validationZip($zip)
    {
        $area = self::where('initial_zip', '<=', $zip)
            ->where('final_zip', '>=', $zip)
            ->orderBy('prevent', 'desc')
            ->orderBy('initial_zip', 'desc')
            ->orderBy('final_zip', 'desc')
            ->first();

        if ($area && !$area->prevent) {
            return $area;
        }

        return false;
    }

}
