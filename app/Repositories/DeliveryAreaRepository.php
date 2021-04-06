<?php

namespace App\Repositories;

use App\Models\DeliveryArea;
use App\Repositories\BaseRepository;

/**
 * Class DeliveryAreaRepository
 * @package App\Repositories
 * @version April 6, 2021, 3:21 pm UTC
*/

class DeliveryAreaRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'initial_zip',
        'final_zip',
        'price',
        'prevent'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return DeliveryArea::class;
    }
}
