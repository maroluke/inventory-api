<?php

namespace App\Models;

use App\Models\InventoryItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *  required={"branch", "room"},
 *  @OA\Xml(name="Location"),
 *  @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 *  @OA\Property(property="branch", type="string", example="Academy"),
 *  @OA\Property(property="room", type="string", example="301"),
 *  @OA\Property(property="shelf", type="string", example="1"),
 *  @OA\Property(property="compartment", type="string", example="1a"),
 *  @OA\Property(property="description", type="text", example="Dieser Ort gehört zu dem Lernenden Jeremy Becker"),
 *  @OA\Property(property="inventoryItems", ref="#/components/schemas/InventoryItem"),
 *  @OA\Property(property="user", ref="#/components/schemas/User"),
 * )
 */

class Location extends Model
{
    public function user() {
        return $this->hasOne(User::class);
    }

    public function inventoryItems() {
        return $this->hasMany(InventoryItem::class);
    }
}
