<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *  path="/user",
     *  summary="List Users",
     *  description="Get a list of all users.",
     *  operationId="userList",
     *  tags={"user"},
     *  security={{"apiAuth": {}}},
     *  @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\JsonContent(
     *          type="array",
     *          @OA\Items(ref="#/components/schemas/User"),
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
        return UserResource::collection(User::all());
    }

    /**
     * @OA\Get(
     *  path="/user/{id}",
     *  summary="Show User",
     *  description="Get a specific user.",
     *  operationId="userShow",
     *  tags={"user"},
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
     *      @OA\JsonContent(ref="#/components/schemas/User"),
     *  ),
     *  @OA\Response(
     *      response=401,
     *      description="Authorization token invalid.",
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="The User does not exist.",
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
        return new UserResource(User::findOrFail($id));
    }

    /**
     * @OA\Patch(
     *  path="/user/{id}",
     *  summary="Update an User",
     *  description="Update an existing user.",
     *  operationId="userUpdate",
     *  tags={"user"},
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
     *      name="name",
     *      description="The name of the user.",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="string",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="location_id",
     *      description="The location of the book.",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="integer",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="is_admin",
     *      description="If the user has admin privileges.",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="boolean",
     *      ),
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\JsonContent(ref="#/components/schemas/User"),
     *  ),
     *  @OA\Response(
     *      response=401,
     *      description="Authorization token invalid.",
     *  ),
     *  @OA\Response(
     *      response=422,
     *      description="The entered parameters are not valid.",
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="The User does not exist.",
     *  ),
     * )
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'string',
            'location_id' => 'exists:App\Models\Location,id',
            'is_admin' => 'boolean',
        ]);

        $user = User::findOrFail($id);
        if ($request->name) $user->name = $request->name;
        if ($request->location_id) $user->location_id = $request->location_id;
        if ($request->is_admin) $user->is_admin = $request->is_admin;
        $user->save();

        return $user;
    }

    /**
     * @OA\Delete(
     *  path="/user/{id}",
     *  summary="Delete User",
     *  description="Delete an user.",
     *  operationId="userDelete",
     *  tags={"user"},
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
     *      description="The User does not exist.",
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
        $user = User::findOrFail($id);
        $user->delete();
    }
}
