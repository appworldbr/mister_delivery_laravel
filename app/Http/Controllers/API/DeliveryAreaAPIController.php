<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreateDeliveryAreaAPIRequest;
use App\Http\Requests\API\UpdateDeliveryAreaAPIRequest;
use App\Models\DeliveryArea;
use App\Repositories\DeliveryAreaRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Response;

/**
 * Class DeliveryAreaController
 * @package App\Http\Controllers\API
 */

class DeliveryAreaAPIController extends AppBaseController
{
    /** @var  DeliveryAreaRepository */
    private $deliveryAreaRepository;

    public function __construct(DeliveryAreaRepository $deliveryAreaRepo)
    {
        $this->deliveryAreaRepository = $deliveryAreaRepo;
    }

    /**
     * Display a listing of the DeliveryArea.
     * GET|HEAD /deliveryAreas
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'zip' => 'size:8',
        ]);

        if ($validator->fails()) {
            return $this->sendError("Tamanho de CEP Inválido", 400);
        }

        $zip = $request->get('zip');
        $area = DeliveryArea::validationZip($zip);
        $responseData = [
            'deliverable' => !!$area,
            'price' => $area ? $area->price : 0,
        ];

        return $this->sendResponse($responseData, 'Delivery Areas retrieved successfully');
    }

    /**
     * Store a newly created DeliveryArea in storage.
     * POST /deliveryAreas
     *
     * @param CreateDeliveryAreaAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateDeliveryAreaAPIRequest $request)
    {
        $input = $request->all();

        $deliveryArea = $this->deliveryAreaRepository->create($input);

        return $this->sendResponse($deliveryArea->toArray(), 'Delivery Area saved successfully');
    }

    /**
     * Display the specified DeliveryArea.
     * GET|HEAD /deliveryAreas/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var DeliveryArea $deliveryArea */
        $deliveryArea = $this->deliveryAreaRepository->find($id);

        if (empty($deliveryArea)) {
            return $this->sendError('Delivery Area not found');
        }

        return $this->sendResponse($deliveryArea->toArray(), 'Delivery Area retrieved successfully');
    }

    /**
     * Update the specified DeliveryArea in storage.
     * PUT/PATCH /deliveryAreas/{id}
     *
     * @param int $id
     * @param UpdateDeliveryAreaAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDeliveryAreaAPIRequest $request)
    {
        $input = $request->all();

        /** @var DeliveryArea $deliveryArea */
        $deliveryArea = $this->deliveryAreaRepository->find($id);

        if (empty($deliveryArea)) {
            return $this->sendError('Delivery Area not found');
        }

        $deliveryArea = $this->deliveryAreaRepository->update($input, $id);

        return $this->sendResponse($deliveryArea->toArray(), 'DeliveryArea updated successfully');
    }

    /**
     * Remove the specified DeliveryArea from storage.
     * DELETE /deliveryAreas/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var DeliveryArea $deliveryArea */
        $deliveryArea = $this->deliveryAreaRepository->find($id);

        if (empty($deliveryArea)) {
            return $this->sendError('Delivery Area not found');
        }

        $deliveryArea->delete();

        return $this->sendSuccess('Delivery Area deleted successfully');
    }
}
