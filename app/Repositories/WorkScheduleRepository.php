<?php

namespace App\Repositories;

use App\Models\WorkSchedule;
use App\Repositories\BaseRepository;

/**
 * Class WorkScheduleRepository
 * @package App\Repositories
 * @version March 31, 2021, 8:55 pm UTC
*/

class WorkScheduleRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'weekday',
        'start-time',
        'end_time'
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
        return WorkSchedule::class;
    }
}
