<?php

namespace App\Http\Controllers;

use App\DataTables\DeliveryAreaDataTable;
use App\Http\Controllers\AppBaseController;
use App\Models\DeliveryArea;
use App\Repositories\DeliveryAreaRepository;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $input['initial_zip'] = zip_db_format($input['initial_zip']);
        $input['final_zip'] = zip_db_format($input['final_zip']);
        $input['price'] = price_to_float($input['price']);

        Validator::make($input, DeliveryArea::getRules())->validate();

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
     * @param Request $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $deliveryArea = $this->deliveryAreaRepository->find($id);

        if (empty($deliveryArea)) {
            Flash::error('Delivery Area not found');

            return redirect(route('deliveryAreas.index'));
        }
        $data = $request->all();
        $data['initial_zip'] = zip_db_format($data['initial_zip']);
        $data['final_zip'] = zip_db_format($data['final_zip']);
        $data['price'] = price_to_float($data['price']);

        Validator::make($data, DeliveryArea::getRules($id))->validate();

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
