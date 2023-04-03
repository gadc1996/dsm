<?php

namespace App\Http\Controllers;

use App\Http\Requests\Delay\DelayUpdateRequest;
use App\Http\Requests\Delay\DelayStoreRequest;
use App\Models\Delay;
use Illuminate\Http\JsonResponse;

class DelayController extends Controller
{
    public function __construct()
    {
        // $this->authorizeResource(Delay::class);
    }

    public function index(): JsonResponse
    {
        return response()->json(Delay::paginate(), 200);
    }

    public function store(DelayStoreRequest $request): JsonResponse
    {
        $data = $request->validated();
        $delay = Delay::create($data);
        return response()->json($delay, 201);
    }

    public function show(Delay $delay): JsonResponse
    {
        return response()->json($delay, 200);
    }

    public function update(DelayUpdateRequest $request, Delay $delay): JsonResponse
    {
        $data = $request->validated();
        $delay->update($data);

        return response()->json($delay, 200);
    }

    public function destroy(Delay $delay): JsonResponse
    {
        $delay->delete();
        return response()->json([], 204);
    }
}
