<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\TaskStoreRequest;
use App\Http\Requests\Task\TaskUpdateRequest;
use App\Models\Task;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    public function __construct()
    {
        // $this->authorizeResource(Task::class);
    }

    public function index(): JsonResponse
    {
        return response()->json(Task::paginate(), 200);
    }

    public function store(TaskStoreRequest $request): JsonResponse
    {
        $data = $request->validated();
        $task = Task::create($data);
        return response()->json($task, 201);
    }

    public function show(Task $task): JsonResponse
    {
        return response()->json($task, 200);
    }

    public function update(TaskUpdateRequest $request, Task $task): JsonResponse
    {
        $data = $request->validated();
        \Log::info($data);
        $task->update($data);

        return response()->json($task, 200);
    }

    public function destroy(Task $task): JsonResponse
    {
        $task->delete();
        return response()->json([], 204);
    }
}
