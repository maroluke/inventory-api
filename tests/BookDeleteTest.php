<?php

use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class BookDeleteTest extends TestCase
{
    /**
     * Test deleting a book.
     *
     * @return void
     */
    public function testBookDelete()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->delete("api/book/2");
        $this->seeStatusCode(200);
    }

    /**
     * Test deleting a book without Login.
     *
     * @return void
     */
    public function testBookDeleteWithoutLogin()
    {
        $this->delete("api/book/3");
        $this->seeStatusCode(401);
    }

    /**
     * Test deleting not existing book.
     *
     * @return void
     */
    public function testBookDeleteNotExisting()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->delete("api/book/999999");
        $this->seeStatusCode(404);
    }
}
