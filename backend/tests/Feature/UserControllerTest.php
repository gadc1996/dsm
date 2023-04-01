<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Mocks\UserMock;
use Tests\TestCase;
use Tests\Traits\UseHeaders;
use Tests\Traits\UsePermissions;
use Tests\Traits\UseRoles;

class UserControllerTest extends TestCase
{
    use RefreshDatabase,
        UseHeaders,
        UseRoles,
        UsePermissions;

    public array $permissions = [
        'users.list',
        'users.create',
        'users.show',
        'users.update',
        'users.destroy'
    ];

    public array $roles = [
        'admin'
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->createPermissions($this->permissions);
        $this->createRoles($this->roles);
        $this->givePermissionsToRole($this->permissions, 'admin');
    }

    public function testAdminCanListUsers(): void
    {
        $admin = UserMock::create();
        $admin->assignRole('admin');

        $headers = $this->getHeadersForUser($admin);
        $this->withHeaders($headers)
            ->getJson('api/users')
            ->assertHeader('content-type', 'application/json')
            ->assertOk();
    }

    public function testAdminCanCreateUser(): void
    {
        $admin = UserMock::create();
        $admin->assignRole('admin');

        $headers = $this->getHeadersForUser($admin);

        $data = UserMock::make()->makeVisible('password')->toArray();

        $this->withHeaders($headers)
            ->postJson('api/users', $data)
            ->assertHeader('content-type', 'application/json')
            ->assertCreated();

        $this->assertDatabaseHas('users', [
            'name' => $data['name'],
            'email' => $data['email']
        ]);
    }

    public function testAdminCanFindUser(): void
    {
        $admin = UserMock::create();
        $admin->assignRole('admin');

        $headers = $this->getHeadersForUser($admin);

        $user = UserMock::create();

        $this->withHeaders($headers)
            ->getJson("api/users/{$user->id}")
            ->assertHeader('content-type', 'application/json')
            ->assertOk();
    }

    public function testAdminCanUpdateUser(): void
    {
        $admin = UserMock::create();
        $admin->assignRole('admin');

        $headers = $this->getHeadersForUser($admin);

        $user = UserMock::create();
        $data = UserMock::make()->toArray();

        $this->withHeaders($headers)
            ->putJson("api/users/{$user->id}", $data)
            ->assertHeader('content-type', 'application/json')
            ->assertOk();

        $this->assertDatabaseHas('users', [
            'name' => $data['name'],
            'email' => $data['email']
        ]);
    }

    public function testAdminCanDeleteUser(): void
    {
        $admin = UserMock::create();
        $admin->assignRole('admin');

        $headers = $this->getHeadersForUser($admin);

        $user = UserMock::create();

        $this->withHeaders($headers)
            ->deleteJson("api/users/{$user->id}")
            ->assertNoContent();

        $this->assertDatabaseMissing('users', [
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }
}
