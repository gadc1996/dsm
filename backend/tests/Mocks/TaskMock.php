<?php

namespace Tests\Mocks;

use App\Models\Task;
use Tests\Interfaces\Mock;

class TaskMock implements Mock
{
    public static function create(array $params = []): Task
    {
        return Task::factory()->create(Self::dependencies($params));
    }

    public static function make(array $params = []): Task
    {
        return Task::factory()->make(Self::dependencies($params));
    }

    public static function dependencies(array $params): array
    {
        return [
            'created_by_id' => UserMock::create()->id,
            'assigned_to_id' => UserMock::create()->id,
            ...$params
        ];
    }
}



