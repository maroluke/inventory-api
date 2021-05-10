<?php

use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class InventoryItemCreateTest extends TestCase
{
    /**
    * Test the creation of an inventory item using valid parameters.
    *
    * @return void
    */
   public function testInventoryItemCreationValidParameters()
   {
       $user = User::all()->random();

       $this->actingAs($user, 'api')
            ->post("api/inventoryitem", [
           'name' => 'Buch',
           'user_id' => $user->id,
           'location_id' => '1',  
           'tags' => 'book',
       ]);
       $this->seeStatusCode(200);
   }

   /**
    * Test the creation of an inventory item using only required parameters.
    *
    * @return void
    */
    public function testInventoryItemCreationRequiredParameters()
    {
        $user = User::all()->random();
 
        $this->actingAs($user, 'api')
             ->post("api/inventoryitem", [
            'name' => 'Buch',
        ]);
        $this->seeStatusCode(200);
    }

   /**
    * Test the creation of an inventory item with missing name.
    *
    * @return void
    */
   public function testInventoryItemCreationMissingName()
   {
       $user = User::all()->random();

       $this->actingAs($user, 'api')
            ->post("api/inventoryitem", [
           'name' => '',
       ]);
       $this->seeStatusCode(422);
   }

   /**
     * Test the creation of an InventoryItem with a non existent user id.
     *
     * @return void
     */
    public function testInventoryItemCreationFalseUserId()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->post("api/inventoryitem", [
            'name' => 'Buch',
            'user_id' => '999999',
        ]);
        $this->seeStatusCode(422);
    }

    /**
     * Test the creation of an InventoryItem with a non existent location id.
     *
     * @return void
     */
    public function testInventoryItemCreationFalseLocationId()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->post("api/inventoryitem", [
            'name' => 'Buch',
            'location_id' => '999999',
        ]);
        $this->seeStatusCode(422);
    }

   /**
    * Test the creation of an inventory item without login.
    *
    * @return void
    */
   public function testInventoryItemCreationWithoutLogin()
   {
       $this->post("api/inventoryitem", [
           'name' => 'Buch',
           'user_id' => '1',
           'location_id' => '1',  
       ]);
       $this->seeStatusCode(401);
   }
}
