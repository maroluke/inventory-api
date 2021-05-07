<?php

use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class LocationAccessTest extends TestCase
{
    /**
     * Test to access the list of Locations.
     *
     * @return void
     */
    public function testLocationList()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->get("api/location");
        $this->seeStatusCode(200);
    }

    /**
     * Test to access the list of Locations without login.
     *
     * @return void
     */
    public function testLocationListWithoutLogin()
    {

        $this->get("api/location");
        $this->seeStatusCode(401);
    }

    /**
     * Test to access a Location.
     *
     * @return void
     */
    public function testLocationShow()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->get("api/location/10");
        $this->seeStatusCode(200);
    }

    /**
     * Test to access a Location without login.
     *
     * @return void
     */
    public function testLocationShowWithoutLogin()
    {

        $this->get("api/location/10");
        $this->seeStatusCode(401);
    }

    /**
     * Test to access a Location that doesn't exist.
     *
     * @return void
     */
    public function testLocationShowNotExistent()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->get("api/location/999999");
        $this->seeStatusCode(404);
    }
}
