<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookBaseResource extends JsonResource
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
            'inventoryItem' => $this->inventoryItem->id,
        ];
    }
}
