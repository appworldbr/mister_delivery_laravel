<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateUserAddressAPIRequest;
use App\Http\Requests\API\UpdateUserAddressAPIRequest;
use App\Models\UserAddress;
use App\Repositories\UserAddressRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class UserAddressController
 * @package App\Http\Controllers\API
 */

class UserAddressAPIController extends AppBaseController
{
    /** @var  UserAddressRepository */
    private $userAddressRepository;

    public function __construct(UserAddressRepository $userAddressRepo)
    {
        $this->userAddressRepository = $userAddressRepo;
    }

    /**
     * Display a listing of the UserAddress.
     * GET|HEAD /userAddresses
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $userAddresses = $this->userAddressRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($userAddresses->toArray(), 'User Addresses retrieved successfully');
    }

    /**
     * Store a newly created UserAddress in storage.
     * POST /userAddresses
     *
     * @param CreateUserAddressAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateUserAddressAPIRequest $request)
    {
        $input = $request->all();

        $userAddress = $this->userAddressRepository->create($input);

        return $this->sendResponse($userAddress->toArray(), 'User Address saved successfully');
    }

    /**
     * Display the specified UserAddress.
     * GET|HEAD /userAddresses/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var UserAddress $userAddress */
        $userAddress = $this->userAddressRepository->find($id);

        if (empty($userAddress)) {
            return $this->sendError('User Address not found');
        }

        return $this->sendResponse($userAddress->toArray(), 'User Address retrieved successfully');
    }

    /**
     * Update the specified UserAddress in storage.
     * PUT/PATCH /userAddresses/{id}
     *
     * @param int $id
     * @param UpdateUserAddressAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserAddressAPIRequest $request)
    {
        $input = $request->all();

        /** @var UserAddress $userAddress */
        $userAddress = $this->userAddressRepository->find($id);

        if (empty($userAddress)) {
            return $this->sendError('User Address not found');
        }

        $userAddress = $this->userAddressRepository->update($input, $id);

        return $this->sendResponse($userAddress->toArray(), 'UserAddress updated successfully');
    }

    /**
     * Remove the specified UserAddress from storage.
     * DELETE /userAddresses/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var UserAddress $userAddress */
        $userAddress = $this->userAddressRepository->find($id);

        if (empty($userAddress)) {
            return $this->sendError('User Address not found');
        }

        $userAddress->delete();

        return $this->sendSuccess('User Address deleted successfully');
    }
}
