<?php

namespace App\Http\Resources;

use App\Http\Resources\InventoryItemBaseResource;
use App\Http\Resources\UserBaseResource;
use Illuminate\Http\Resources\Json\JsonResource;

class LocationResource extends JsonResource
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
            'branch' => $this->branch,
            'room' => $this->room,
            'shelf' => $this->shelf,
            'compartment' => $this->compartment,
            'description' => $this->description,
            'user' => new UserBaseResource($this->user),
            'inventoryItems' => InventoryItemBaseResource::collection($this->inventoryItems),
        ];
    }
}
