<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    public function user() {
        return $this->hasOne(User::class);
    }
}
