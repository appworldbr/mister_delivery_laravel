<?php

namespace App\Http\Controllers;

use App\DataTables\WorkScheduleDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateWorkScheduleRequest;
use App\Http\Requests\UpdateWorkScheduleRequest;
use App\Repositories\WorkScheduleRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class WorkScheduleController extends AppBaseController
{
    /** @var  WorkScheduleRepository */
    private $workScheduleRepository;

    public function __construct(WorkScheduleRepository $workScheduleRepo)
    {
        $this->workScheduleRepository = $workScheduleRepo;
    }

    /**
     * Display a listing of the WorkSchedule.
     *
     * @param WorkScheduleDataTable $workScheduleDataTable
     * @return Response
     */
    public function index(WorkScheduleDataTable $workScheduleDataTable)
    {
        return $workScheduleDataTable->render('work_schedules.index');
    }

    /**
     * Show the form for creating a new WorkSchedule.
     *
     * @return Response
     */
    public function create()
    {
        return view('work_schedules.create');
    }

    /**
     * Store a newly created WorkSchedule in storage.
     *
     * @param CreateWorkScheduleRequest $request
     *
     * @return Response
     */
    public function store(CreateWorkScheduleRequest $request)
    {
        $input = $request->all();

        $workSchedule = $this->workScheduleRepository->create($input);

        Flash::success('Work Schedule saved successfully.');

        return redirect(route('workSchedules.index'));
    }

    /**
     * Display the specified WorkSchedule.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $workSchedule = $this->workScheduleRepository->find($id);

        if (empty($workSchedule)) {
            Flash::error('Work Schedule not found');

            return redirect(route('workSchedules.index'));
        }

        return view('work_schedules.show')->with('workSchedule', $workSchedule);
    }

    /**
     * Show the form for editing the specified WorkSchedule.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $workSchedule = $this->workScheduleRepository->find($id);

        if (empty($workSchedule)) {
            Flash::error('Work Schedule not found');

            return redirect(route('workSchedules.index'));
        }

        return view('work_schedules.edit')->with('workSchedule', $workSchedule);
    }

    /**
     * Update the specified WorkSchedule in storage.
     *
     * @param  int              $id
     * @param UpdateWorkScheduleRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateWorkScheduleRequest $request)
    {
        $workSchedule = $this->workScheduleRepository->find($id);

        if (empty($workSchedule)) {
            Flash::error('Work Schedule not found');

            return redirect(route('workSchedules.index'));
        }

        $workSchedule = $this->workScheduleRepository->update($request->all(), $id);

        Flash::success('Work Schedule updated successfully.');

        return redirect(route('workSchedules.index'));
    }

    /**
     * Remove the specified WorkSchedule from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $workSchedule = $this->workScheduleRepository->find($id);

        if (empty($workSchedule)) {
            Flash::error('Work Schedule not found');

            return redirect(route('workSchedules.index'));
        }

        $this->workScheduleRepository->delete($id);

        Flash::success('Work Schedule deleted successfully.');

        return redirect(route('workSchedules.index'));
    }
}
