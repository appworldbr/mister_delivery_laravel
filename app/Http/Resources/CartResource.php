<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
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
            'food' => new FoodResource($this->food),
            'extras' => CartExtraResource::collection($this->extras),
            'observation' => $this->observation,
            'quantity' => $this->quantity,
            'total' => $this->getTotal($this->food, $this->extras),
        ];
    }
}
