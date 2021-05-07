<?php

use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class CreateBook extends TestCase
{
    /**
     * Test the creation of a book using valid parameters.
     *
     * @return void
     */
    public function testBookCreationValidParameters()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->post("api/book", [
            'name' => 'Buch',
            'user_id' => $user->id,
            'location_id' => '1',
            'isbn' => 'isbn number',
            'author' => 'Author Name',
            'excerpt' => 'About the book.',
            'releaseDate' => '01-01-2000 00:00:00',
            'language' => 'de',  
        ]);
        $this->seeStatusCode(200);
    }

    /**
     * Test the creation of a book using only required parameters.
     *
     * @return void
     */
    public function testBookCreationRequiredParameters()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->post("api/book", [
            'name' => 'Buch',
            'author' => 'Author Name',
            'language' => 'de',  
        ]);
        $this->seeStatusCode(200);
    }

    /**
     * Test the creation of a book with missing name.
     *
     * @return void
     */
    public function testBookCreationMissingName()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->post("api/book", [
            'author' => 'Author Name',
            'language' => 'de',  
        ]);
        $this->seeStatusCode(422);
    }

    /**
     * Test the creation of a book with missing author.
     *
     * @return void
     */
    public function testBookCreationMissingAuthor()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->post("api/book", [
            'name' => 'Buch',
            'language' => 'de',  
        ]);
        $this->seeStatusCode(422);
    }

    /**
     * Test the creation of a book with missing language.
     *
     * @return void
     */
    public function testBookCreationMissingLanguage()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->post("api/book", [
            'name' => 'Buch',
            'author' => 'Author Name',
        ]);
        $this->seeStatusCode(422);
    }

    /**
     * Test the creation of a book with a non existent user id.
     *
     * @return void
     */
    public function testBookCreationFalseUserId()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->post("api/book", [
            'name' => 'Buch',
            'user_id' => '999999',
            'author' => 'Author Name',
            'language' => 'de',  
        ]);
        $this->seeStatusCode(422);
    }

    /**
     * Test the creation of a book with a non existent location id.
     *
     * @return void
     */
    public function testBookCreationFalseLocationId()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->post("api/book", [
            'name' => 'Buch',
            'location_id' => '999999',
            'author' => 'Author Name',
            'language' => 'de',  
        ]);
        $this->seeStatusCode(422);
    }

    /**
     * Test the creation of a book with a wrong date format.
     *
     * @return void
     */
    public function testBookCreationWrongDateFormat()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->post("api/book", [
            'name' => 'Buch',
            'location_id' => '999999',
            'author' => 'Author Name',
            'release_date' => '10. Mai 2019',
            'language' => 'de',  
        ]);
        $this->seeStatusCode(422);
    }

    /**
     * Test the creation of a book without login.
     *
     * @return void
     */
    public function testBookCreationWithoutLogin()
    {
        $this->post("api/book", [
            'name' => 'Buch',
            'author' => 'Author Name',
            'language' => 'de',  
        ]);
        $this->seeStatusCode(401);
    }
}
