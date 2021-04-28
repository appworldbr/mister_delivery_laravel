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
            'extras' => FoodFavoriteExtraResource::collection($this->whenLoaded("extras")),
            'observation' => $this->when($request->routeIs('cart.show'), $this->observation),
        ];
    }
}
