<?php

namespace App\Repositories;

use App\Models\WorkSchedule;
use App\Repositories\BaseRepository;

/**
 * Class WorkScheduleRepository
 * @package App\Repositories
 * @version April 1, 2021, 7:04 pm UTC
*/

class WorkScheduleRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'weekday',
        'start_time',
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
