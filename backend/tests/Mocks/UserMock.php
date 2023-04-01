<?php

namespace Tests\Mocks;

use App\Models\User;
use Tests\Interfaces\Mock;

class UserMock implements Mock
{
    public static function create(array $params = []): User
    {
        return User::factory()->create(Self::dependencies($params));
    }

    public static function make(array $params = []): User
    {
        return User::factory()->make(Self::dependencies($params));
    }

    public static function dependencies(array $params): array
    {
        return [
            ...$params
        ];
    }
}


