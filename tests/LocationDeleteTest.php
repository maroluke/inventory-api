<?php

use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class LocationDeleteTest extends TestCase
{
    /**
     * Test deleting a location.
     *
     * @return void
     */
    public function testLocationItemDelete()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->delete("api/location/2");
        $this->seeStatusCode(200);
    }

    /**
     * Test deleting a location without Login.
     *
     * @return void
     */
    public function testLocationDeleteWithoutLogin()
    {
        $this->delete("api/location/2");
        $this->seeStatusCode(401);
    }

    /**
     * Test deleting not existing location.
     *
     * @return void
     */
    public function testLocationDeleteNotExisting()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->delete("api/location/999999");
        $this->seeStatusCode(404);
    }
}
