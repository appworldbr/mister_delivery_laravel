<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderFoodResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'observation' => $this->when($request->routeIs('order.show'), $this->observation),
            'quantity' => $this->quantity,
            'price' => round((float) $this->getRawOriginal('price'), 2),
            'extras' => $this->when($request->routeIs('order.show'), OrderExtraResource::collection($this->extras)),
        ];
    }
}
