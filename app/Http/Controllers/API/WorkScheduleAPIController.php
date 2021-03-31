<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateWorkScheduleAPIRequest;
use App\Http\Requests\API\UpdateWorkScheduleAPIRequest;
use App\Models\WorkSchedule;
use App\Repositories\WorkScheduleRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class WorkScheduleController
 * @package App\Http\Controllers\API
 */

class WorkScheduleAPIController extends AppBaseController
{
    /** @var  WorkScheduleRepository */
    private $workScheduleRepository;

    public function __construct(WorkScheduleRepository $workScheduleRepo)
    {
        $this->workScheduleRepository = $workScheduleRepo;
    }

    /**
     * Display a listing of the WorkSchedule.
     * GET|HEAD /workSchedules
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $workSchedules = $this->workScheduleRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($workSchedules->toArray(), 'Work Schedules retrieved successfully');
    }

    /**
     * Store a newly created WorkSchedule in storage.
     * POST /workSchedules
     *
     * @param CreateWorkScheduleAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateWorkScheduleAPIRequest $request)
    {
        $input = $request->all();

        $workSchedule = $this->workScheduleRepository->create($input);

        return $this->sendResponse($workSchedule->toArray(), 'Work Schedule saved successfully');
    }

    /**
     * Display the specified WorkSchedule.
     * GET|HEAD /workSchedules/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var WorkSchedule $workSchedule */
        $workSchedule = $this->workScheduleRepository->find($id);

        if (empty($workSchedule)) {
            return $this->sendError('Work Schedule not found');
        }

        return $this->sendResponse($workSchedule->toArray(), 'Work Schedule retrieved successfully');
    }

    /**
     * Update the specified WorkSchedule in storage.
     * PUT/PATCH /workSchedules/{id}
     *
     * @param int $id
     * @param UpdateWorkScheduleAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateWorkScheduleAPIRequest $request)
    {
        $input = $request->all();

        /** @var WorkSchedule $workSchedule */
        $workSchedule = $this->workScheduleRepository->find($id);

        if (empty($workSchedule)) {
            return $this->sendError('Work Schedule not found');
        }

        $workSchedule = $this->workScheduleRepository->update($input, $id);

        return $this->sendResponse($workSchedule->toArray(), 'WorkSchedule updated successfully');
    }

    /**
     * Remove the specified WorkSchedule from storage.
     * DELETE /workSchedules/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var WorkSchedule $workSchedule */
        $workSchedule = $this->workScheduleRepository->find($id);

        if (empty($workSchedule)) {
            return $this->sendError('Work Schedule not found');
        }

        $workSchedule->delete();

        return $this->sendSuccess('Work Schedule deleted successfully');
    }
}
