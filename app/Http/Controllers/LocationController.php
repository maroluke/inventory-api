<?php

namespace App\Http\Controllers;

use App\Http\Resources\LocationResource;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * @OA\Get(
     *  path="/location",
     *  summary="List Locations",
     *  description="Get a list of all locations.",
     *  operationId="locationList",
     *  tags={"location"},
     *  security={{"bearerAuth":{}}},
     *  @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\JsonContent(
     *          type="array",
     *          @OA\Items(ref="#/components/schemas/Location"),
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
        return LocationResource::collection(Location::all());
    }

    /**
     * @OA\Post(
     *  path="/location",
     *  summary="Create Locations",
     *  description="Create a new location.",
     *  operationId="locationCreate",
     *  tags={"location"},
     *  security={{"bearerAuth":{}}},
     *  @OA\Parameter(
     *      name="branch",
     *      description="The branch of the company.",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="string",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="room",
     *      description="The room the location is in.",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="string",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="shelf",
     *      description="The shelf where the location is.",
     *      required=false,
     *      in="path",
     *      @OA\Schema(
     *          type="string",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="compartment",
     *      description="The compartment in the shelf.",
     *      required=false,
     *      in="path",
     *      @OA\Schema(
     *          type="string",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="description",
     *      description="A short description of the location.",
     *      required=false,
     *      in="path",
     *      @OA\Schema(
     *          type="text",
     *      ),
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\JsonContent(ref="#/components/schemas/Location"),
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
            'branch' => 'required|string',
            'room' => 'required|string',
            'shelf' => 'string',
            'compartment' => 'string',
            'description' => 'string'
        ]);

        $location = new Location;
        $location->branch = $request->branch;
        $location->room = $request->room;
        $location->shelf = $request->shelf;
        $location->compartment = $request->compartment;
        $location->description = $request->description;

        $location->save();

        return $location;
    }

    /**
     * @OA\Get(
     *  path="/location/{id}",
     *  summary="Show Location",
     *  description="Get a specific location.",
     *  operationId="locationShow",
     *  tags={"location"},
     *  security={{"bearerAuth":{}}},
     *  @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\JsonContent(ref="#/components/schemas/Location"),
     *  ),
     *  @OA\Response(
     *      response=401,
     *      description="Authorization token invalid.",
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="The Location does not exist.",
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
        return new LocationResource(Location::findOrFail($id));
    }

    /**
     * /**
     * @OA\Patch(
     *  path="/location/{id}",
     *  summary="Update a Location",
     *  description="Update a existing location.",
     *  operationId="locationUpdate",
     *  tags={"location"},
     *  security={{"bearerAuth":{}}},
     *  @OA\Parameter(
     *      name="branch",
     *      description="The branch of the company.",
     *      required=false,
     *      in="path",
     *      @OA\Schema(
     *          type="string",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="room",
     *      description="The room the location is in.",
     *      required=false,
     *      in="path",
     *      @OA\Schema(
     *          type="string",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="shelf",
     *      description="The shelf where the location is.",
     *      required=false,
     *      in="path",
     *      @OA\Schema(
     *          type="string",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="compartment",
     *      description="The compartment in the shelf.",
     *      required=false,
     *      in="path",
     *      @OA\Schema(
     *          type="string",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="description",
     *      description="A short description of the location.",
     *      required=false,
     *      in="path",
     *      @OA\Schema(
     *          type="text",
     *      ),
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\JsonContent(ref="#/components/schemas/Location"),
     *  ),
     *  @OA\Response(
     *      response=401,
     *      description="Authorization token invalid.",
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="The Location does not exist.",
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
            'branch' => 'string',
            'room' => 'string',
            'shelf' => 'string',
            'compartment' => 'string',
            'description' => 'string'
        ]);

        $location = Location::findOrFail($id);
        if ($request->branch) $location->branch = $request->branch;
        if ($request->room) $location->room = $request->room;
        if ($request->shelf) $location->shelf = $request->shelf;
        if ($request->compartment) $location->compartment = $request->compartment;
        if ($request->description) $location->description = $request->description;

        $location->save();

        return $location;
    }

    /**
     * @OA\Delete(
     *  path="/location/{id}",
     *  summary="Delete Location",
     *  description="Delete a location.",
     *  operationId="locationDelete",
     *  tags={"location"},
     *  security={{"bearerAuth":{}}},
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
     *      description="The Location does not exist.",
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
        $location = Location::findOrFail($id);
        $location->delete();
    }
}
