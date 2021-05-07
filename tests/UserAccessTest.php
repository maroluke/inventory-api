<?php

use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UserAccessTest extends TestCase
{
    /**
     * Test to access the list of Users.
     *
     * @return void
     */
    public function testUserList()
    {
        $user = User::findOrFail(1);

        $this->actingAs($user, 'api')
             ->get("api/user");
        $this->seeStatusCode(200);
    }

    /**
     * Test to access the list of Users without login.
     *
     * @return void
     */
    public function testUserListWithoutLogin()
    {

        $this->get("api/user");
        $this->seeStatusCode(401);
    }

    /**
     * Test to access the list of Users without administrator privileges.
     *
     * @return void
     */
    public function testUserListWithoutAdmin()
    {
        $user = User::findOrFail(5);

        $this->actingAs($user, 'api')
             ->get("api/user");
        $this->seeStatusCode(401);
    }

    /**
     * Test to access a User.
     *
     * @return void
     */
    public function testUserShow()
    {
        $user = User::findOrFail(1);

        $this->actingAs($user, 'api')
             ->get("api/user/5");
        $this->seeStatusCode(200);
    }

    /**
     * Test to access a User without login.
     *
     * @return void
     */
    public function testUserShowWithoutLogin()
    {

        $this->get("api/user/5");
        $this->seeStatusCode(401);
    }

    /**
     * Test to access a User without administrator privileges.
     *
     * @return void
     */
    public function testUserShowWithoutAdmin()
    {
        $user = User::findOrFail(5);

        $this->actingAs($user, 'api')
             ->get("api/user/5");
        $this->seeStatusCode(401);
    }

    /**
     * Test to access a User that doesn't exist.
     *
     * @return void
     */
    public function testUserShowNotExistent()
    {
        $user = User::findOrFail(1);

        $this->actingAs($user, 'api')
             ->get("api/user/999999");
        $this->seeStatusCode(404);
    }
}
