<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        $token = User::authAttempt($credentials);
        return $token
            ? response()->json($token, 200)
            : response()->json(['error' => 'Unauthorized'], 401);
    }

    public function user(): JsonResponse
    {
        return response()->json(auth()->user(), 200);
    }
}
