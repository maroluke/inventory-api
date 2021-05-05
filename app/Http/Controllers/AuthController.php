<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * @OA\Post(
     *  path="/auth/register",
     *  summary="Register",
     *  description="Create a new account",
     *  operationId="authRegister",
     *  tags={"auth"},
     *  @OA\Parameter(
     *      name="name",
     *      description="The name of the user from the account.",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="string",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="email",
     *      description="The email of the user from the account.",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="string",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="password",
     *      description="The password the account will get to log in.",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="string",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="password_confirmation",
     *      description="The password confirmation to assure the password is correct.",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="string",
     *      ),
     *  ),
     *  @OA\Response(
     *      response=201,
     *      description="Registration successful.",
     *      @OA\JsonContent(ref="#/components/schemas/User")
     *  ),
     *  @OA\Response(
     *      response=422,
     *      description="The entered parameters are not valid.",
     *  ),
     *  @OA\Response(
     *      response=409,
     *      description="A User with the given e-mail-address already exists.",
     *  ),
     * )
     */
    public function register(Request $request) {
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);

        try {

            $user = new User;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $plainPassword = $request->input('password');
            $user->password = app('hash')->make($plainPassword);

            $location = new Location;
            $location->branch = 'Academy';
            $location->room = '000';
            $location->description = 'Arbeitsplatz von ' . $request->name;
            $location->save();

            $user->location_id = $location->id;

            $user->save();

            return response()->json(['user' => $user, 'message' => 'CREATED'], 201);

        } catch (\Exception $e) {
            return response()->json(['message' => 'User Registration Failed!'], 409);
        }
    }

    /**
     * @OA\Post(
     *  path="/auth/login",
     *  summary="Log in",
     *  description="Log in and get an access token.",
     *  operationId="authLogin",
     *  tags={"auth"},
     *  @OA\Parameter(
     *      name="email",
     *      description="The email of the user.",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="string",
     *      ),
     *  ),
     *  @OA\Parameter(
     *      name="password",
     *      description="The chosen password of the user.",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="string",
     *      ),
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Registration successful.",
     *  ),
     *  @OA\Response(
     *      response=422,
     *      description="The entered parameters are not valid.",
     *  ),
     *  @OA\Response(
     *      response=401,
     *      description="The given e-mail and password do not match.",
     *  ),
     * )
     */
    public function login()
    {
        try {
            $credentials = request(['email', 'password']);

            if (! $token = auth()->attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'The given credentials are invalid!'], 422);
        }
}

    /**
     * @OA\Post(
     *  path="/auth/logout",
     *  summary="Log out",
     *  description="Log out and make the token invalid.",
     *  operationId="authLogout",
     *  tags={"auth"},
     *  security={{"bearerAuth":{}}},
     *  @OA\Response(
     *      response=200,
     *      description="Log out successful.",
     *  ),
     *  @OA\Response(
     *      response=401,
     *      description="Authorization token invalid.",
     *  ),
     * )
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * @OA\Post(
     *  path="/auth/refresh",
     *  summary="Refresh",
     *  description="Refresh the time on the access token.",
     *  operationId="authRefresh",
     *  tags={"auth"},
     *  security={{"bearerAuth":{}}},
     *  @OA\Response(
     *      response=200,
     *      description="Your access token time is refreshed.",
     *  ),
     *  @OA\Response(
     *      response=401,
     *      description="Authorization token invalid.",
     *  ),
     * )
     */
    public function refresh()
    {
        $token = auth()->refresh();

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
