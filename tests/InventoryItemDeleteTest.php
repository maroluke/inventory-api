<?php

use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class InventoryItemDeleteTest extends TestCase
{
    /**
     * Test deleting an inventory item.
     *
     * @return void
     */
    public function testInventoryItemDelete()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->delete("api/inventoryitem/2");
        $this->seeStatusCode(200);
    }

    /**
     * Test deleting an inventory item without Login.
     *
     * @return void
     */
    public function testInventoryItemDeleteWithoutLogin()
    {
        $this->delete("api/inventoryitem/2");
        $this->seeStatusCode(401);
    }

    /**
     * Test deleting not existing inventory item.
     *
     * @return void
     */
    public function testInventoryItemDeleteNotExisting()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->delete("api/inventoryitem/999999");
        $this->seeStatusCode(404);
    }
}
