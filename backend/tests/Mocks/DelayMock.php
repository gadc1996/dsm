<?php

namespace Tests\Mocks;

use App\Models\Delay;
use Tests\Interfaces\Mock;

class DelayMock implements Mock
{
    public static function create(array $params = []): Delay
    {
        return Delay::factory()->create(Self::dependencies($params));
    }

    public static function make(array $params = []): Delay
    {
        return Delay::factory()->make(Self::dependencies($params));
    }

    public static function dependencies(array $params): array
    {
        return [
            'task_id' => TaskMock::create()->id,
            ...$params
        ];
    }
}



