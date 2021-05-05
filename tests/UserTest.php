<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    /**
     * Test the user registration with correct example date.
     *
     * @return void
     */
    public function testRegisterUser()
    {
        $this->post("api/auth/register", [
            "name" => "Jeremy Becker",
            "email" => "jeremy.becker@twofold.swiss",
            "password" => "1234",
            "password_confirmation" => "1234"
        ]);
        $this->seeStatusCode(201);
    }

    /**
     * Test the registration with the same user.
     *
     * @return void
     */
    public function testRegisterExistingUser()
    {
        $this->post("api/auth/register", [
            "name" => "Jeremy Becker",
            "email" => "jeremy.becker@twofold.swiss",
            "password" => "1234",
            "password_confirmation" => "1234"
        ]);
        $this->seeStatusCode(422);
    }

    /**
     * Test the user registration with wrong data.
     *
     * @return void
     */
    public function testRegisterWrongData()
    {
        $this->post("api/auth/register", [
            "name" => "Jeremy Becker",
            "email" => "jeremy.becker",
            "password" => "1234",
            "password_confirmation" => "1234"
        ]);
        $this->seeStatusCode(422);
    }

    /**
     * Test the user registration with missing data.
     *
     * @return void
     */
    public function testRegisterMissingData()
    {
        $this->post("api/auth/register", [
            "email" => "jeremy.becker",
            "password" => "1234",
            "password_confirmation" => "1234"
        ]);
        $this->seeStatusCode(422);
    }

    /**
     * Test the user login with correct credentials.
     *
     * @return void
     */
    public function testLoginCorrectCredentials()
    {
        $this->post("api/auth/login", [
            "email" => "jeremy.becker@twofold.swiss",
            "password" => "1234",
        ]);
        $this->seeStatusCode(200);
    }

    /**
     * Test the user login with incorrect credentials.
     *
     * @return void
     */
    public function testLoginIncorrectCredentials()
    {
        $this->post("api/auth/login", [
            "email" => "jeremy.becker@twofold.swiss",
            "password" => "wrongPassword",
        ]);
        $this->seeStatusCode(401);
    }

    /**
     * Test the user login with missing credentials.
     *
     * @return void
     */
    public function testLoginMissingCredentials()
    {
        $this->post("api/auth/login", [
            "email" => "jeremy.becker@twofold.swiss",
        ]);
        $this->seeStatusCode(422);
    }
}
