<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FoodResource extends JsonResource
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
            'image_url' => $this->image_url,
            'name' => $this->name,
            'price' => (double) $this->getRawOriginal('price'),
            'description' => $this->description,
            'has_details' => $this->when(
                $request->routeIs('food.index') || $request->routeIs('food.category'),
                $this->has_details
            ),
            'extras' => $this->when(
                $request->routeIs('food.show'),
                FoodExtraResource::collection($this->category->extras()->active()->get())
            ),
        ];
    }
}
