<?php

namespace App\Repositories;

use App\Models\UserAddress;
use App\Repositories\BaseRepository;

/**
 * Class UserAddressRepository
 * @package App\Repositories
 * @version March 30, 2021, 6:55 pm UTC
*/

class UserAddressRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'zip',
        'state',
        'city',
        'district',
        'address',
        'number',
        'complement',
        'use_id'
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
        return UserAddress::class;
    }
}
