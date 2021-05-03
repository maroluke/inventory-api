<?php

namespace App\Models;

use App\Models\InventoryItem;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public function inventoryItem()
    {
        return $this->morphOne(InventoryItem::class, 'type');
    }
}
