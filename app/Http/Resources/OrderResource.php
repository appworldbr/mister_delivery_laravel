<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'food' => OrderFoodResource::collection($this->food),
            'delivery_fee' => (float) $this->getRawOriginal('delivery_fee'),
            'total' => $this->getTotal($this->food),
            'status' => $this->status,
            'created_at' => $this->created_at,
        ];
    }
}
