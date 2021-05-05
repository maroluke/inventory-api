<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\User;
use App\Models\Location;
use App\Models\InventoryItem;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(5)->create();
        Location::factory()->count(60)->create();
        InventoryItem::factory()->count(100)->create();
        Book::factory()->count(100)->create();
    }
}
