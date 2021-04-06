<?php

namespace App\Repositories;

use App\Models\FoodCategory;
use App\Repositories\BaseRepository;

/**
 * Class FoodCategoryRepository
 * @package App\Repositories
 * @version April 6, 2021, 7:05 pm UTC
*/

class FoodCategoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'has_details'
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
        return FoodCategory::class;
    }
}
