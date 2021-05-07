<?php

use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class BookTest extends TestCase
{
    /**
     * Test to access the list of Books.
     *
     * @return void
     */
    public function testBookList()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->get("api/book");
        $this->seeStatusCode(200);
    }

    /**
     * Test to access the list of Books without login.
     *
     * @return void
     */
    public function testBookListWithoutLogin()
    {

        $this->get("api/book");
        $this->seeStatusCode(401);
    }

    /**
     * Test to access a Book.
     *
     * @return void
     */
    public function testBookShow()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->get("api/book/10");
        $this->seeStatusCode(200);
    }

    /**
     * Test to access a Book without login.
     *
     * @return void
     */
    public function testBookShowWithoutLogin()
    {

        $this->get("api/book/10");
        $this->seeStatusCode(401);
    }

    /**
     * Test to access a Book that doesn't exist.
     *
     * @return void
     */
    public function testBookShowNotExistent()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->get("api/book/999999");
        $this->seeStatusCode(404);
    }
}
