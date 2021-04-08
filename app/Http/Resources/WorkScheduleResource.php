<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkScheduleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'weekday' => $this->weekname,
            'start_time' => (new Carbon($this->start_time))->format('H:i'),
            'end_time' => (new Carbon($this->end_time))->format('H:i')
        ];
    }
}
