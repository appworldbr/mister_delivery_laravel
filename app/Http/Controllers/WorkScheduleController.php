<?php

namespace App\Http\Controllers;

use App\Models\WorkSchedule;

class WorkScheduleController extends Controller
{
    public function index()
    {
        return view("work_schedule.index", [
            'model' => WorkSchedule::class,
        ]);
    }

    public function form(WorkSchedule $workSchedule = null)
    {
        return view("work_schedule.form", compact("workSchedule"));
    }
}
