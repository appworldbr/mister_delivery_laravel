<?php

namespace App\Http\Resources;

use App\Models\WorkSchedule;
use Illuminate\Http\Resources\Json\ResourceCollection;

class WorkScheduleCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $weekday = $request->query('weekday');
        $hour = $request->query('hour');
        $minute = $request->query('minute');
        $time = null;

        if ($weekday) {
            $weekday = (int) $weekday;
        }

        if ($hour) {
            $time = $minute ? "$hour:$minute" : "$hour:00";
        }

        $isOpen = WorkSchedule::isOpen($weekday, $time);

        $output = [
            'schedule' => $this->collection,
            'isOpen' => $isOpen,
        ];

        if (!$isOpen) {
            $output['nextTimeOpen'] = WorkSchedule::nextTimeOpen($weekday, $time);
        }

        return $output;
    }
}
