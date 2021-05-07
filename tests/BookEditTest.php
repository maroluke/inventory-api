<?php

use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class EditBookTest extends TestCase
{
    /**
     * Test updating the isbn of a book.
     *
     * @return void
     */
    public function testBookIsbnUpdate()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->patch("api/book/10", [
            'isbn' => 'Different isbn',
        ]);
        $this->seeStatusCode(200);
    }

    /**
     * Test updating the author of a book.
     *
     * @return void
     */
    public function testBookAuthorUpdate()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->patch("api/book/10", [
            'author' => 'Different author',
        ]);
        $this->seeStatusCode(200);
    }

    /**
     * Test updating the excerpt of a book.
     *
     * @return void
     */
    public function testBookExcerptUpdate()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->patch("api/book/10", [
            'excerpt' => 'Different excerpt',
        ]);
        $this->seeStatusCode(200);
    }

    /**
     * Test updating the release date of a book.
     *
     * @return void
     */
    public function testBookReleaseDateUpdate()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->patch("api/book/10", [
            'release_date' => '2018-05-01',
        ]);
        $this->seeStatusCode(200);
    }

    /**
     * Test updating the release date of a book with wrong format.
     *
     * @return void
     */
    public function testBookReleaseDateUpdateWrongFormat()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->patch("api/book/10", [
            'release_date' => '10. Mai 2019',
        ]);
        $this->seeStatusCode(422);
    }

    /**
     * Test updating the language date of a book.
     *
     * @return void
     */
    public function testBookLanguageUpdate()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->patch("api/book/10", [
            'language' => 'EN',
        ]);
        $this->seeStatusCode(200);
    }

    /**
     * Test updating the author of a book without Login.
     *
     * @return void
     */
    public function testBookAuthorUpdateWithoutLogin()
    {
        $this->patch("api/book/1", [
            'author' => 'Different author',
        ]);
        $this->seeStatusCode(401);
    }
}
