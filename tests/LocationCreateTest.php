<?php

use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class LocationCreateTest extends TestCase
{
     /**
     * Test the creation of a location using valid parameters.
     *
     * @return void
     */
    public function testLocationCreationValidParameters()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->post("api/location", [
            'branch' => 'Twofold Asperger-Academy',
            'room' => '431',
            'shelf' => '3',
            'compartment' => '4',
            'description' => 'This is a description where the location is.'
        ]);
        $this->seeStatusCode(200);
    }

    /**
     * Test the creation of a location using only required parameters.
     *
     * @return void
     */
    public function testLocationCreationRequiredParameters()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->post("api/location", [
            'branch' => 'Twofold Asperger-Academy',
            'room' => '431',
        ]);
        $this->seeStatusCode(200);
    }

    /**
     * Test the creation of a location with missing branch.
     *
     * @return void
     */
    public function testLocationCreationMissingBranch()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->post("api/location", [
            'room' => '431',
        ]);
        $this->seeStatusCode(422);
    }

    /**
     * Test the creation of a location with missing Room.
     *
     * @return void
     */
    public function testLocationCreationMissingRoom()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->post("api/location", [
            'branch' => 'Twofold Asperger-Academy',
        ]);
        $this->seeStatusCode(422);
    }

    /**
     * Test the creation of a location without login.
     *
     * @return void
     */
    public function testLocationCreationWithoutLogin()
    {
        $this->post("api/location", [
            'branch' => 'Twofold Asperger-Academy',
            'room' => '431',
        ]);
        $this->seeStatusCode(401);
    }
}
