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
        $isOpen = WorkSchedule::isOpen(3, '12:00');
        // $isOpen = WorkSchedule::isOpen(4, '20:00');

        $output = [
            'schedule' => $this->collection,
            'isOpen' => $isOpen,
        ];

        if(!$isOpen){
            $output['nextTimeOpen'] = WorkSchedule::nextTimeOpen();
        }

        return $output;
    }
}
