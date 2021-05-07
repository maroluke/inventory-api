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
     * Test the user registration with missing name.
     *
     * @return void
     */
    public function testRegisterMissingName()
    {
        $this->post("api/auth/register", [
            "email" => "jeremy.becker@twofold.swiss",
            "password" => "1234",
            "password_confirmation" => "1234"
        ]);
        $this->seeStatusCode(422);
    }

    /**
     * Test the user registration with missing email.
     *
     * @return void
     */
    public function testRegisterMissingEmail()
    {
        $this->post("api/auth/register", [
            "name" => "Jeremy Becker",
            "password" => "1234",
            "password_confirmation" => "1234"
        ]);
        $this->seeStatusCode(422);
    }

    /**
     * Test the user registration with missing password.
     *
     * @return void
     */
    public function testRegisterMissingPassword()
    {
        $this->post("api/auth/register", [
            "name" => "Jeremy Becker",
            "email" => "jeremy.becker@twofold.swiss",
            "password_confirmation" => "1234"
        ]);
        $this->seeStatusCode(422);
    }

    /**
     * Test the user registration with missing password confirmation.
     *
     * @return void
     */
    public function testRegisterMissingPasswordConfirmation()
    {
        $this->post("api/auth/register", [
            "name" => "Jeremy Becker",
            "email" => "jeremy.becker@twofold.swiss",
            "password" => "1234",
        ]);
        $this->seeStatusCode(422);
    }

    /**
     * Test the user registration with wrong email format.
     *
     * @return void
     */
    public function testRegisterWrongEmailFormat()
    {
        $this->post("api/auth/register", [
            "name" => "Jeremy Becker",
            "email" => "jeremy.becker@twofold",
            "password" => "1234",
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
     * Test the user login with unregistered email.
     *
     * @return void
     */
    public function testLoginFalseEmail()
    {
        $this->post("api/auth/login", [
            "email" => "jeremy.becker1@twofold.swiss",
            "password" => "1234",
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
