<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserTaskController extends Controller
{
    public function current(User $user): JsonResponse
    {
        return response()->json($user->tasks()->current()->get(), 200);
    }

    public function pending(User $user): JsonResponse
    {
        return response()->json($user->tasks()->pending()->get(), 200);
    }
}
