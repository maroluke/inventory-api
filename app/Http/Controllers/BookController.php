<?php

namespace App\Http\Controllers;

use App\Http\Controllers\InventoryItemController;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * @OA\Get(
     *  path="/book",
     *  summary="List Books",
     *  description="Get a list of all books.",
     *  operationId="bookList",
     *  tags={"book"},
     *  security={{"apiAuth": {}}},
     *  @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\JsonContent(
     *          type="array",
     *          @OA\Items(ref="#/components/schemas/Book"),
     *      ),
     *  ),
     *  @OA\Response(
     *      response=401,
     *      description="Authorization token invalid.",
     *  ),
     * )
     * 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return BookResource::collection(Book::all());
    }

    /**
     * @OA\Post(
     *  path="/book",
     *  summary="Create a Book",
     *  description="Create a new book.",
     *  operationId="bookCreate",
     *  tags={"book"},
     *  security={{"apiAuth": {}}},
     *  @OA\Parameter(
     *      name="name",
     *      description="The name of the new inventory item the book belongs to.",
     *      required=true,
     *      in="query",
     *      @OA\Schema(
     *          type="string",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="user_id",
     *      description="The user who owns the object.",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="integer",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="location_id",
     *      description="The location where the book is stored.",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="integer",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="isbn",
     *      description="The isbn of the book.",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="string",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="author",
     *      description="The author of the book.",
     *      required=true,
     *      in="query",
     *      @OA\Schema(
     *          type="string",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="excerpt",
     *      description="A short text describing the book.",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="text",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="release_date",
     *      description="The date the book was released on.",
     *      required=false,
     *      in="query",
     *      example="2021-04-30",
     *      @OA\Schema(
     *          type="date",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="language",
     *      description="The language the book is written in.",
     *      required=true,
     *      in="query",
     *      @OA\Schema(
     *          type="string",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="category",
     *      description="The category the book belongs to.",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="string",
     *      ),
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\JsonContent(ref="#/components/schemas/Book"),
     *  ),
     *  @OA\Response(
     *      response=401,
     *      description="Authorization token invalid.",
     *  ),
     *  @OA\Response(
     *      response=422,
     *      description="The entered parameters are not valid.",
     *  ),
     * )
     * 
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'user_id' => 'exists:App\Models\User,id',
            'location_id' => 'exists:App\Models\Location,id',
            'isbn' => 'string',
            'author' => 'required|string',
            'excerpt' => 'string',
            'release_date' => 'date',
            'language' => 'required|string',
            'category' => 'string',
        ]);

        $inventoryItemController = new InventoryItemController;
        $inventoryItem = $inventoryItemController->store($request);

        $book = new Book;
        $book->isbn = $request->isbn;
        $book->author = $request->author;
        $book->excerpt = $request->excerpt;
        $book->release_date = $request->release_date;
        $book->language = $request->language;
        $book->category = $request->category;
        $book->save();

        $inventoryItem->type()->associate($book)->save();

        return $book;
    }

    /**
     * @OA\Get(
     *  path="/book/{id}",
     *  summary="Show Book",
     *  description="Get a specific book.",
     *  operationId="bookShow",
     *  tags={"book"},
     *  security={{"apiAuth": {}}},
     *  @OA\Parameter(
     *      name="id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer",
     *      ),
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\JsonContent(ref="#/components/schemas/Book"),
     *  ),
     *  @OA\Response(
     *      response=401,
     *      description="Authorization token invalid.",
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="The Book does not exist.",
     *  ),
     * )
     * 
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new BookResource(Book::findOrFail($id));
    }


    /**
     * @OA\Patch(
     *  path="/book/{id}",
     *  summary="Update a book",
     *  description="Update a existing book.",
     *  operationId="bookUpdate",
     *  tags={"book"},
     *  security={{"apiAuth": {}}},
     *  @OA\Parameter(
     *      name="id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="isbn",
     *      description="The isbn of the book.",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="string",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="author",
     *      description="The author of the book.",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="string",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="excerpt",
     *      description="A short text describing the book.",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="text",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="release_date",
     *      description="The date the book was released on.",
     *      required=false,
     *      in="query",
     *      example="2021-04-30",
     *      @OA\Schema(
     *          type="date",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="language",
     *      description="The language the book is written in.",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="string",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="category",
     *      description="The category the book belongs to.",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="string",
     *      ),
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\JsonContent(ref="#/components/schemas/Book"),
     *  ),
     *  @OA\Response(
     *      response=401,
     *      description="Authorization token invalid.",
     *  ),
     *  @OA\Response(
     *      response=422,
     *      description="The entered parameters are not valid.",
     *  ),
     * )
     * 
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'isbn' => 'string',
            'author' => 'string',
            'excerpt' => 'string',
            'release_date' => 'date',
            'language' => 'string',
            'category' => 'string',
        ]);

        $book = Book::findOrFail($id);
        if ($request->isbn) $book->isbn = $request->isbn;
        if ($request->author) $book->author = $request->author;
        if ($request->excerpt) $book->excerpt = $request->excerpt;
        if ($request->release_date) $book->release_date = $request->release_date;
        if ($request->language) $book->language = $request->language;
        if ($request->category) $book->category = $request->category;
        $book->save();

        return $book;
    }

    /**
     * @OA\Delete(
     *  path="/book/{id}",
     *  summary="Delete Book",
     *  description="Delete a book.",
     *  operationId="bookDelete",
     *  tags={"book"},
     *  security={{"apiAuth": {}}},
     *  @OA\Parameter(
     *      name="id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer",
     *      ),
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Success",
     *  ),
     *  @OA\Response(
     *      response=401,
     *      description="Authorization token invalid.",
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="The Book does not exist.",
     *  ),
     * )
     * 
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        if ($inventoryItem = $book->inventoryItem) {
            $inventoryItem->type_id = null;
            $inventoryItem->type_type = null;
            $inventoryItem->save();
        }
        $book->delete();
    }
}
