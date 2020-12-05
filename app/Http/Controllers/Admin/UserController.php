<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UserController
{
    /**
     * @OA\Get(
     *      path="/users",
     *      operationId="getUsersList",
     *      tags={"Users"},
     *      summary="Get list of users",
     *      description="Returns collection of users",
     *      @OA\Parameter(
     *          name="page",
     *          description="Pagination Page",
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(response=200,description="Successful"),
     *      @OA\Response(response=400, description="Bad Request"),
     *      security={{"bearerAuth": {}}}
     * )
     *
     * Returns list of users
     */
    public function index()
    {
        Gate::authorize('view', 'users');

        $users = User::paginate();

        return UserResource::collection($users);
    }

    /**
     * @OA\Get(
     *      path="/users/{id}",
     *      operationId="getSingleUser",
     *      tags={"Users"},
     *      summary="Get user by id",
     *      description="Returns a single user",
     *      @OA\Parameter(
     *          name="id",
     *          description="User ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(response=200, description="Successful"),
     *      @OA\Response(response=400, description="Bad Request"),
     *      security={{"bearerAuth": {}}}
     * )
     *
     * Returns a single user by id
     */
    public function show($id)
    {
        Gate::authorize('view', 'users');

        $user = User::find($id);
        return new UserResource($user);
    }

    /**
     * @OA\Post(
     *      path="/users",
     *      operationId="createUser",
     *      tags={"Users"},
     *      summary="Create a User",
     *      description="Creates a User",
     *      @OA\Response(response=201, description="Successful"),
     *      @OA\Response(response=400, description="Bad Request"),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UserCreateRequest")
     *      ),
     *      security={{"bearerAuth": {}}},
     * )
     *
     * Creates a User
     */
    public function store(UserCreateRequest $request)
    {
        Gate::authorize('edit', 'users');

        $user = User::create($request->only('first_name', 'last_name', 'email', 'role_id') + [
            'password' => Hash::make('password'),
        ]);

        return response(new UserResource($user), Response::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *      path="/users/{id}",
     *      operationId="updateUser",
     *      tags={"Users"},
     *      summary="Update a User",
     *      description="Updates a User",
     *      @OA\Parameter(
     *          name="id",
     *          description="User ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(response=202, description="Successful"),
     *      @OA\Response(response=400, description="Bad Request"),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UserUpdateRequest")
     *      ),
     *      security={{"bearerAuth": {}}},
     * )
     *
     * Updates a User
     */
    public function update(UserUpdateRequest $request, $id)
    {
        Gate::authorize('edit', 'users');

        $user = User::find($id);
        $user->update($request->only('first_name', 'last_name', 'email', 'role_id'));

        return response(new UserResource($user), Response::HTTP_ACCEPTED);
    }

    /**
     * @OA\Delete(
     *      path="/users/{id}",
     *      operationId="deleteUser",
     *      tags={"Users"},
     *      summary="Delete a User",
     *      description="Delete a User by Id",
     *      @OA\Parameter(
     *          name="id",
     *          description="User ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(response=204, description="Successful"),
     *      @OA\Response(response=400, description="Bad Request"),
     *      security={{"bearerAuth": {}}}
     * )
     *
     * Deletes a user by id
     */
    public function destroy($id)
    {
        Gate::authorize('edit', 'users');

        User::destroy($id);
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
