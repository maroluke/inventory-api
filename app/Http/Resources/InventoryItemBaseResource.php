<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InventoryItemBaseResource extends JsonResource
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
            'type_id' => $this->type_id,
            'type_type' => $this->type_type, 
            'user_id' => $this->user_id,
            'location_id' => $this->location_id,
            'in_use' => $this->when($this->relationLoaded('location'), function() {
                return $this->location->user == null ? false : true;
            }),
            'tags' => $this->tags,
        ];
    }
}
