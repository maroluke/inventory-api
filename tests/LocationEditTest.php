<?php

use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class LocationTest extends TestCase
{
    /**
     * Update the branch of a location.
     *
     * @return void
     */
    public function testLocationBranchUpdate()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->patch("api/location/10", [
            'branch' => 'Twofold',
        ]);
        $this->seeStatusCode(200);
    }

    /**
     * Update the room of a location.
     *
     * @return void
     */
    public function testLocationRoomUpdate()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->patch("api/location/10", [
            'room' => '100',
        ]);
        $this->seeStatusCode(200);
    }

    /**
     * Update the shelf of a location.
     *
     * @return void
     */
    public function testLocationShelfUpdate()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->patch("api/location/10", [
            'shelf' => '12',
        ]);
        $this->seeStatusCode(200);
    }

    /**
     * Update the compartment of a location.
     *
     * @return void
     */
    public function testLocationCompartmentUpdate()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->patch("api/location/10", [
            'compartment' => 'Top left',
        ]);
        $this->seeStatusCode(200);
    }

    /**
     * Update the description of a location.
     *
     * @return void
     */
    public function testLocationDescriptionUpdate()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->patch("api/location/10", [
            'description' => 'This is a location.',
        ]);
        $this->seeStatusCode(200);
    }
    
    /**
     * Update a location without login.
     *
     * @return void
     */
    public function testLocationUpdateWithoutLogin()
    {
        $this->patch("api/location/10", [
            'branch' => 'Twofold',
            'room' => '105',
            'shelf' => '9',
        ]);
        $this->seeStatusCode(401);
    }
}
