<?php

namespace App\Http\Controllers;

use App\DataTables\DeliveryAreaDataTable;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateDeliveryAreaRequest;
use App\Http\Requests\UpdateDeliveryAreaRequest;
use App\Models\DeliveryArea;
use App\Repositories\DeliveryAreaRepository;
use Flash;
use Response;

class DeliveryAreaController extends AppBaseController
{
    /** @var  DeliveryAreaRepository */
    private $deliveryAreaRepository;

    public function __construct(DeliveryAreaRepository $deliveryAreaRepo)
    {
        $this->deliveryAreaRepository = $deliveryAreaRepo;
    }

    /**
     * Display a listing of the DeliveryArea.
     *
     * @param DeliveryAreaDataTable $deliveryAreaDataTable
     * @return Response
     */
    public function index(DeliveryAreaDataTable $deliveryAreaDataTable)
    {
        return $deliveryAreaDataTable->render('delivery_areas.index');
    }

    /**
     * Show the form for creating a new DeliveryArea.
     *
     * @return Response
     */
    public function create()
    {
        return view('delivery_areas.create');
    }

    /**
     * Store a newly created DeliveryArea in storage.
     *
     * @param CreateDeliveryAreaRequest $request
     *
     * @return Response
     */
    public function store(CreateDeliveryAreaRequest $request)
    {
        $input = $request->all();
        $input['inital_zip'] = price_to_float($input['initial_zip']);
        $input['final_zip'] = zip_to_float($input['final_zip']);
        $input['price'] = zip_to_float($input['price']);
        $deliveryArea = $this->deliveryAreaRepository->create($input);

        Flash::success('Delivery Area saved successfully.');

        return redirect(route('deliveryAreas.index'));
    }

    /**
     * Display the specified DeliveryArea.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        
        $deliveryArea = $this->deliveryAreaRepository->find($id);        

        if (empty($deliveryArea)) {
            Flash::error('Delivery Area not found');

            return redirect(route('deliveryAreas.index'));
        }

        return view('delivery_areas.show')->with('deliveryArea', $deliveryArea);
    }

    /**
     * Show the form for editing the specified DeliveryArea.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $deliveryArea = $this->deliveryAreaRepository->find($id);

        if (empty($deliveryArea)) {
            Flash::error('Delivery Area not found');

            return redirect(route('deliveryAreas.index'));
        }

        return view('delivery_areas.edit')->with('deliveryArea', $deliveryArea);
    }

    /**
     * Update the specified DeliveryArea in storage.
     *
     * @param  int              $id
     * @param UpdateDeliveryAreaRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDeliveryAreaRequest $request)
    {
        $deliveryArea = $this->deliveryAreaRepository->find($id);

        if (empty($deliveryArea)) {
            Flash::error('Delivery Area not found');

            return redirect(route('deliveryAreas.index'));
        }
        $data = $request->all();
        $data['price'] = price_to_float($data['price']);
        $data['initial_zip'] = zip_to_float($data['initial_zip']);
        dd($data['initial_zip']);
        $data['final_zip'] = zip_to_float($data['final_zip']);
        
        $deliveryArea = $this->deliveryAreaRepository->update($data, $id);

        Flash::success('Delivery Area updated successfully.');

        return redirect(route('deliveryAreas.index'));
    }

    /**
     * Remove the specified DeliveryArea from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $deliveryArea = $this->deliveryAreaRepository->find($id);

        if (empty($deliveryArea)) {
            Flash::error('Delivery Area not found');

            return redirect(route('deliveryAreas.index'));
        }

        $this->deliveryAreaRepository->delete($id);

        Flash::success('Delivery Area deleted successfully.');

        return redirect(route('deliveryAreas.index'));
    }
}
