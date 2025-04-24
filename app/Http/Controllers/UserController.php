<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use OpenApi\Annotations as OA;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/users",
     *     tags={"Users"},
     *     summary="Get list of users",
     *     @OA\Response(
     *         response=200,
     *         description="A list of users",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/User"))
     *     )
     * )
     */
    public function index()
    {
        $users = User::all();
        return response()->json([
            'message' => 'Get All Users successfully',
            'users' => $users
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     */
    /**
     * @OA\Get(
     *     path="/api/users/{id}",
     *     tags={"Users"},
     *     summary="Get user by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="User ID",
     *         @OA\Schema(type="integer")
     *     ),
     *  
     *     @OA\Response(
     *         response=404,
     *         description="User not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User not found")
     *         )
     *     )
     * )
     */

    public function show(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }
        return response()->json([
            'message' => 'Get User by id successfully ',
            'user' => new UserResource($user)
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * @OA\Post(
     *     path="/api/users",
     *     tags={"Users"},
     *     summary="Create a new user",
     *     @OA\Response(
     *         response=201,
     *         description="User created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     )
     * )
     */
    public function store(UserRequest $request)
    {
        // Validasi sudah dijalankan otomatis oleh Laravel
        $user = User::create($request->validated());

        return response()->json([
            'message' => 'User created successfully',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'age' => $user->age,
            ]
        ], 201);
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {}

    /**
     * Update the specified resource in storage.
     */
    /**
     * @OA\Put(
     *     path="/api/users/{id}",
     *     tags={"Users"},
     *     summary="Update a user by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the user to update",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", example="johndoe@example.com"),
     *             @OA\Property(property="age", type="integer", example=30)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User updated successfully"),
     *             @OA\Property(property="user", ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation Error"
     *     )
     * )
     */

    public function update(UserRequest $request, string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }

        $validated = $request->validated();

        $user->update($validated);

        return response()->json([
            'message' => 'User updated successfully',
            'user' => new UserResource($user),
        ], 200);
    }





    /**
     * Remove the specified resource from storage.
     */
    /**
     * @OA\Delete(
     *     path="/api/users/{id}",
     *     tags={"Users"},
     *     summary="Delete a user by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the user to delete",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User deleted successfully"),
     *             @OA\Property(property="user", ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User not found")
     *         )
     *     )
     * )
     */

    public function destroy(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }
        $user->delete();
        return response()->json([
            'message' => 'User deleted successfully',
            'user' => new UserResource($user)
        ], 200);
    }
}
