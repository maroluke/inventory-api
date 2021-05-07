<?php

namespace App\Http\Resources;

use App\Http\Resources\BookBaseResource;
use App\Http\Resources\LocationBaseResource;
use App\Http\Resources\UserBaseResource;
use Illuminate\Http\Resources\Json\JsonResource;

class InventoryItemResource extends JsonResource
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
            'type' => $this->when($this->relationLoaded('type'), function () {
                if ($this->type instanceof App\Models\Book) {
                    return new BookBaseResource($this->type);
                }
            }),
            'user' => new UserBaseResource($this->user),
            'location' => new LocationBaseResource($this->location),
            'in_use' => $this->when($this->relationLoaded('location'), function() {
                if ($this->location) {
                    return $this->location->user == null ? false : true;
                } else {
                    return false;
                }
            }),
        ];
    }
}
