<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LocationBaseResource extends JsonResource
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
            'user_id' => $this->user_id,
            'inventoryItems' => $this->inventoryItems::lists('id')->toArray(),
        ];
    }
}
