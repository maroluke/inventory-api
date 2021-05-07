<?php

use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class InventoryItemTest extends TestCase
{
    /**
     * Test updating the name of an inventory item.
     *
     * @return void
     */
    public function testInventoryItemNameUpdate()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->patch("api/inventoryitem/10", [
            'name' => 'Different book',
        ]);
        $this->seeStatusCode(200);
    }

    /**
     * Test updating the type of an inventory item.
     *
     * @return void
     */
    public function testInventoryItemTypeUpdate()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->patch("api/inventoryitem/10", [
            'type_id' => '1',
            'type_type' => 'App\\Models\\Book'
        ]);
        $this->seeStatusCode(200);
    }

    /**
     * Test updating the type of an inventory item to a item that doesn't exist.
     *
     * @return void
     */
    public function testInventoryItemTypeUpdateNotExistent()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->patch("api/inventoryitem/10", [
            'type_id' => '999999',
            'type_type' => 'App\\Models\\Book'
        ]);
        $this->seeStatusCode(422);
    }

    /**
     * Test updating the type of an inventory item to a item type that doesn't exist.
     *
     * @return void
     */
    public function testInventoryItemTypeUpdateNotExistentType()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->patch("api/inventoryitem/10", [
            'type_id' => '1',
            'type_type' => 'App\\Models\\Books'
        ]);
        $this->seeStatusCode(422);
    }

    /**
     * Test updating the user of an inventory item.
     *
     * @return void
     */
    public function testInventoryItemUserIdUpdate()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->patch("api/inventoryitem/10", [
            'user_id' => '2',
        ]);
        $this->seeStatusCode(200);
    }

    /**
     * Test updating the user of an inventory item that doesn't exist.
     *
     * @return void
     */
    public function testInventoryItemUserIdUpdateNotExistent()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->patch("api/inventoryitem/10", [
            'user_id' => '999999',
        ]);
        $this->seeStatusCode(422);
    }

    /**
     * Test updating the location of an inventory item.
     *
     * @return void
     */
    public function testInventoryItemLocationIdUpdate()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->patch("api/inventoryitem/10", [
            'location_id' => '2',
        ]);
        $this->seeStatusCode(200);
    }

    /**
     * Test updating the location of an inventory item that doesn't exist.
     *
     * @return void
     */
    public function testInventoryItemLocationIdUpdateNotExistent()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->patch("api/inventoryitem/10", [
            'location_id' => '999999',
        ]);
        $this->seeStatusCode(422);
    }

    /**
     * Test updating the user of an inventory item.
     *
     * @return void
     */
    public function testInventoryItemUserUpdate()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->patch("api/inventoryitem/1", [
            'user_id' => 2,
        ]);
        $this->seeStatusCode(200);
    }

    /**
     * Test updating the location of an inventory item.
     *
     * @return void
     */
    public function testInventoryItemLocationUpdate()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->patch("api/inventoryitem/1", [
            'location_id' => 31,
        ]);
        $this->seeStatusCode(200);
    }

    /**
     * Test updating the name of an inventory item without login.
     *
     * @return void
     */
    public function testInventoryItemNameUpdateWithoutLogin()
    {
        $this->patch("api/inventoryitem/1", [
            'name' => 'Anderes Buch',
        ]);
        $this->seeStatusCode(401);
    }
}
