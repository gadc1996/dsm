<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;

class UserController extends Controller
{
    public function __construct()
    {
        // $this->authorizeResource(User::class);
    }

    public function index(): JsonResponse
    {
        return response()->json(User::paginate(), 200);
    }

    public function store(UserStoreRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = User::create(Arr::except($data, ['role']));

        if(array_key_exists('role', $data))
            $user->assignRole($data['role']);

        return response()->json($user, 201);
    }

    public function show(User $user): JsonResponse
    {
        return response()->json($user, 200);
    }

    public function update(UserUpdateRequest $request, User $user): JsonResponse
    {
        $data = $request->validated();
        $user->update($data);

        return response()->json($user, 200);
    }

    public function destroy(User $user): JsonResponse
    {
        $user->delete();
        return response()->json([], 204);
    }
}
