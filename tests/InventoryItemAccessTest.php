<?php

use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class InventoryItemAccessTest extends TestCase
{
    /**
     * Test to access the list of InventoryItems.
     *
     * @return void
     */
    public function testInventoryItemList()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->get("api/inventoryitem");
        $this->seeStatusCode(200);
    }

    /**
     * Test to access the list of InventoryItems without login.
     *
     * @return void
     */
    public function testInventoryItemListWithoutLogin()
    {

        $this->get("api/inventoryitem");
        $this->seeStatusCode(401);
    }

    /**
     * Test to access an InventoryItem.
     *
     * @return void
     */
    public function testInventoryItemShow()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->get("api/inventoryitem/10");
        $this->seeStatusCode(200);
    }

    /**
     * Test to access an InventoryItem without login.
     *
     * @return void
     */
    public function testInventoryItemShowWithoutLogin()
    {

        $this->get("api/inventoryitem/10");
        $this->seeStatusCode(401);
    }

    /**
     * Test to access an InventoryItem that doesn't exist.
     *
     * @return void
     */
    public function testInventoryItemShowNotExistent()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->get("api/inventoryItem/999999");
        $this->seeStatusCode(404);
    }
}
