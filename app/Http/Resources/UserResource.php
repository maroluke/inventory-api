<?php

namespace App\Http\Resources;

use App\Http\Resources\InventoryItemBaseResource;
use App\Http\Resources\LocationBaseResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'location' => new LocationBaseResource($this->location),
            'inventoryItems' => $this->when($this->relationLoaded('location'), function () {
                if ($this->location) return InventoryItemBaseResource::collection($this->location->inventoryItems);
            }),
        ];
    }
}
