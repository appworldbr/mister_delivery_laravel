<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\WorkSchedule;
use Illuminate\Http\Request;

class WorkScheduleController extends Controller
{
    public function index(Request $request)
    {
        $weekday = $request->query('weekday');
        $hour = $request->query('hour');
        $minute = $request->query('minute');
        $time = null;

        if ($weekday) {
            $weekday = (int) $weekday;
        }

        if ($hour) {
            $time = $minute ? "$hour:$minute:00" : "$hour:00:00";
        }

        $isOpen = WorkSchedule::isOpen($weekday, $time);
        $output = [
            'schedule' => WorkSchedule::ordered()->get(),
            'isOpen' => $isOpen,
        ];

        if (!$isOpen) {
            $output['nextTimeOpen'] = WorkSchedule::nextTimeOpen($weekday, $time);
        }

        return response()->json($output);
    }
}
