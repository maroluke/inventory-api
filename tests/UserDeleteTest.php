<?php

use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UserDeleteTest extends TestCase
{
    /**
     * Test deleting an user.
     *
     * @return void
     */
    public function testUserDelete()
    {
        $user = User::findOrFail(1);

        $this->actingAs($user, 'api')
             ->delete("api/user/2");
        $this->seeStatusCode(200);
    }

    /**
     * Test deleting an user without Login.
     *
     * @return void
     */
    public function testUserDeleteWithoutLogin()
    {
        $this->delete("api/user/3");
        $this->seeStatusCode(401);
    }

    /**
     * Test deleting an user without administrator privileges.
     *
     * @return void
     */
    public function testUserDeleteWithoutAdmin()
    {
        $user = User::findOrFail(5);

        $this->actingAs($user, 'api')
             ->delete("api/user/4");
        $this->seeStatusCode(401);
    }

    /**
     * Test deleting not existing user.
     *
     * @return void
     */
    public function testUserDeleteNotExisting()
    {
        $user = User::findOrFail(1);

        $this->actingAs($user, 'api')
             ->delete("api/user/999999");
        $this->seeStatusCode(404);
    }
}
