<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateInfoRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create($request->only('first_name', 'last_name', 'email') + [
            'password' => Hash::make($request->password),
            'is_influencer' => 1,
        ]);

        return response($user, Response::HTTP_CREATED);
    }

    public function login(Request $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            $token = $user->createToken('admin')->accessToken;

            $cookie = cookie('jwt', $token, 3600);

            return response([
                'token' => $token,
            ])->withCookie($cookie);

            // return [
            //     'token' => $token,
            // ];
        }

        return response([
            'error' => 'Invalid Credentials',
        ], Response::HTTP_UNAUTHORIZED);
    }

    public function logout()
    {
        $cookie = Cookie::forget('jwt');

        return response([
            'message' => 'Logout Successful!',
        ])->withCookie($cookie);
    }

    /**
     * @OA\Get(
     *      path="/user",
     *      operationId="getUserDetails",
     *      tags={"Profile"},
     *      summary="Get User Details",
     *      description="Returns details of authenticated user",
     *      @OA\Response(response=200,description="Successful"),
     *      @OA\Response(response=400, description="Bad Request"),
     *      security={{"bearerAuth": {}}}
     * )
     *
     * Returns users information
     */
    public function user()
    {
        $user = Auth::user();

        $resource = new UserResource($user);

        if ($user->isInfluencer()) {
            return $resource;
        }

        return ($resource)->additional([
            'data' => [
                'permissions' => $user->permissions(),
            ],
        ]);
    }

    /**
     * @OA\Put(
     *      path="/users/info",
     *      operationId="updateUserInfo",
     *      tags={"Profile"},
     *      summary="Update User Details",
     *      description="Updates Authenticated User Details",
     *      @OA\Response(response=202, description="Successful"),
     *      @OA\Response(response=400, description="Bad Request"),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UpdateInfoRequest")
     *      ),
     *      security={{"bearerAuth": {}}},
     * )
     *
     * Updates a User Information
     */
    public function updateInfo(UpdateInfoRequest $request)
    {
        $user = Auth::user();

        $user->update($request->only('first_name', 'last_name', 'email'));

        return response(new UserResource($user), Response::HTTP_ACCEPTED);
    }

    /**
     * @OA\Put(
     *      path="/users/password",
     *      operationId="updateUserPassword",
     *      tags={"Profile"},
     *      summary="Update User Password",
     *      description="Updates Authenticated User Password",
     *      @OA\Response(response=202, description="Successful"),
     *      @OA\Response(response=400, description="Bad Request"),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UpdatePasswordRequest")
     *      ),
     *      security={{"bearerAuth": {}}},
     * )
     *
     * Updates a User Password
     */
    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = Auth::user();

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return response(new UserResource($user), Response::HTTP_ACCEPTED);
    }
}
