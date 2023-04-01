<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Mocks\UserMock;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanLogin(): void
    {
        $credentials = [
            'password' => 'password',
            'email' => 'mail@example.com'
        ];

        UserMock::create($credentials);

        $this->postJson('api/auth/login', $credentials)
             ->assertHeader('content-type', 'application/json')
             ->assertOk();
    }

}
