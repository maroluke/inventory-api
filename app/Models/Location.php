<?php

namespace App\Models;

use App\Models\InventoryItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    public function user() {
        return $this->hasOne(User::class);
    }

    public function inventoryItems() {
        return $this->hasMany(InventoryItem::class);
    }
}
