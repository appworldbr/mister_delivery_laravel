<?php

namespace App\Http\Resources;

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
        return [
            'schedule' => $this->collection,
            'isOpen' => true,
            'nextOpenHour' => [
                'week' => 3,
                'hour' => '12:12'
            ]
        ];
    }
}
