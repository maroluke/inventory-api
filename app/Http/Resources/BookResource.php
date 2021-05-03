<?php

namespace App\Http\Resources;

use App\Http\Resources\InventoryItemBaseResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return  [
            'id' => $this->id,
            'isbn' => $this->isbn,
            'author' => $this->author,
            'excerpt' => $this->excerpt,
            'language' => $this->language,
            'inventoryItem' => new InventoryItemBaseResource($this->inventoryItem),
        ];
    }
}
