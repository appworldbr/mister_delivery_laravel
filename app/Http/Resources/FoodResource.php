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
            'imageUrl' => $this->image_url,
            'name' => $this->name,
            'price' => round((float) $this->getRawOriginal('price'), 2),
            'description' => $this->description ?? '',
            'hasDetails' => $this->has_details,
            'extras' => FoodExtraResource::collection($this->whenLoaded('extras')),
        ];
    }
}
