<?php

namespace App\Models;

use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function location() {
        return $this->belongsTo(Location::class);
    }

    public function type() {
        return $this->morphTo();
    }
}
