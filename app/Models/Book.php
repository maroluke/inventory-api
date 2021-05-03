<?php

namespace App\Models;

use App\Models\InventoryItem;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *  required={"author", "language"},
 *  @OA\Xml(name="Book"),
 *  @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 *  @OA\Property(property="isbn", type="string", example="ISBN 978-3-86680-192-9"),
 *  @OA\Property(property="author", type="string", example="Beatrix Münzer-Glas"),
 *  @OA\Property(property="excerpt", type="text", example="Dieser Bildband nimmt den Leser mit auf eine Entdeckungsreise ins vergangene Jahrhundert und präsentiert Liebenswertes und Nachdenkliches aus alten Tagen der Stadt Hof und ihres Umlands. Arnd Kluge und Beatrix Münzer-Glas stellen die Menschen aus der Hofer Region in den Mittelpunkt. Über 160 Aufnahmen lassen die Zeit vom Ende des 19. Jahrhunderts bis 1960 wieder lebendig werden. Eine liebevolle Einladung zum Erinnern, Neu- und Wiederentdecken."),
 *  @OA\Property(property="release_date", type="date", example="02-20-2019"),
 *  @OA\Property(property="language", type="string", example="Deutsch"),
 *  @OA\Property(property="inventoryItem", ref="#/components/schemas/InventoryItem"),
 * )
 */
class Book extends Model
{
    public function inventoryItem()
    {
        return $this->morphOne(InventoryItem::class, 'type');
    }
}
