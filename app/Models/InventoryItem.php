<?php

namespace App\Models;

use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *  required={"name"},
 *  @OA\Xml(name="InventoryItem"),
 *  @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 *  @OA\Property(property="name", type="string", example="Buch: Stadt und Landkreis Hof"),
 *  @OA\Property(property="type", ref="#/components/schemas/Book"),
 *  @OA\Property(property="user", ref="#/components/schemas/User"),
 *  @OA\Property(property="location", ref="#/components/schemas/Location"),
 * )
 */
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
