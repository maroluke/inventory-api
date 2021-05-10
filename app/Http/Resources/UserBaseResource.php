<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserBaseResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'location_id' => $this->location_id,
            'inventoryItems' => $this->when($this->relationLoaded('location'), function () {
                if ($this->location) return $this->location->inventoryItems->pluck('id')->toArray();
            }),
        ];
    }
}
