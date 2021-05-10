<?php

namespace App\Http\Controllers;

use App\Http\Resources\InventoryItemResource;
use App\Models\InventoryItem;
use Illuminate\Http\Request;

class InventoryItemController extends Controller
{
    /**
     * @OA\Get(
     *  path="/inventoryitem",
     *  summary="List InventoryItems",
     *  description="Get a list of all inventoryItems.",
     *  operationId="inventoryItemList",
     *  tags={"inventoryItem"},
     *  security={{"apiAuth": {}}},
     *  @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\JsonContent(
     *          type="array",
     *          @OA\Items(ref="#/components/schemas/InventoryItem"),
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
        return InventoryItemResource::collection(InventoryItem::all());
    }

    /**
     * @OA\Post(
     *  path="/inventoryitem",
     *  summary="Create an InventoryItem",
     *  description="Create a new inventory item.",
     *  operationId="inventoryItemCreate",
     *  tags={"inventoryItem"},
     *  security={{"apiAuth": {}}},
     *  @OA\Parameter(
     *      name="name",
     *      description="The name of the new inventory item.",
     *      required=true,
     *      in="query",
     *      @OA\Schema(
     *          type="string",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="type_id",
     *      description="The id from the child object.",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="integer",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="type_type",
     *      description="The class from the child object.",
     *      required=false,
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
     *      description="The location where the inventory item is stored.",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="integer",
     *      ),
     *  ),
     * @OA\Parameter(
     *      name="tags",
     *      description="The tags of the InventoryItem.",
     *      required=false,
     *      in="query",
     *      example="book",
     *      @OA\Schema(
     *          type="string",
     *      ),
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\JsonContent(ref="#/components/schemas/InventoryItem"),
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
            'type_id' => 'poly_exists:type_type',
            'user_id' => 'exists:App\Models\User,id',
            'location_id' => 'exists:App\Models\Location,id',
            'tags' => 'string',
        ]);

        $inventoryItem = new InventoryItem;
        $inventoryItem->name = $request->name;
        $inventoryItem->type_id = $request->type_id;
        $inventoryItem->type_type = $request->type_type;
        $inventoryItem->user_id = $request->user_id;
        $inventoryItem->location_id = $request->location_id;
        $inventoryItem->tags = $request->tags;
        $inventoryItem->save();

        return $inventoryItem;
    }

    /**
     * @OA\Get(
     *  path="/inventoryitem/{id}",
     *  summary="Show InventoryItem",
     *  description="Get a specific inventory item.",
     *  operationId="inventoryItemShow",
     *  tags={"inventoryItem"},
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
     *      @OA\JsonContent(ref="#/components/schemas/InventoryItem"),
     *  ),
     *  @OA\Response(
     *      response=401,
     *      description="Authorization token invalid.",
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="The InventoryItem does not exist.",
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
        return new InventoryItemResource(InventoryItem::findOrFail($id));
    }

    /**
     * @OA\Patch(
     *  path="/inventoryitem/{id}",
     *  summary="Update an InventoryItem",
     *  description="Update an existing inventory item.",
     *  operationId="inventoryItemUpdate",
     *  tags={"inventoryItem"},
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
     *      description="The name of the new inventory item.",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="string",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="type_id",
     *      description="The id from the child object.",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="integer",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="type_type",
     *      description="The class from the child object.",
     *      required=false,
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
     *      description="The location where the inventory item is stored.",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="integer",
     *      ),
     *  ),
     * @OA\Parameter(
     *      name="tags",
     *      description="The tags of the InventoryItem.",
     *      required=false,
     *      in="query",
     *      example="book",
     *      @OA\Schema(
     *          type="string",
     *      ),
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\JsonContent(ref="#/components/schemas/InventoryItem"),
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
     *      description="The InventoryItem does not exist.",
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
            'name' => 'string',
            'type_id' => 'poly_exists:type_type',
            'user_id' => 'exists:App\Models\User,id',
            'location_id' => 'exists:App\Models\Location,id',
            'tags' => 'string',
        ]);

        $inventoryItem = InventoryItem::findOrFail($id);
        if ($request->name) $inventoryItem->name = $request->name;
        if ($request->type_id) $inventoryItem->type_id = $request->type_id;
        if ($request->type_type) $inventoryItem->type_type = $request->type_type;
        if ($request->user_id) $inventoryItem->user_id = $request->user_id;
        if ($request->location_id) $inventoryItem->location_id = $request->location_id;
        if ($request->tags) $inventoryItem->tags = $request->tags;
        $inventoryItem->save();

        return $inventoryItem;
    }

    /**
     * @OA\Delete(
     *  path="/inventoryitem/{id}",
     *  summary="Delete InventoryItem",
     *  description="Delete an inventory item.",
     *  operationId="inventoryItemDelete",
     *  tags={"inventoryItem"},
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
     *      description="The InventoryItem does not exist.",
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
        $inventoryItem = InventoryItem::findOrFail($id);
        $inventoryItem->delete();
    }
}
