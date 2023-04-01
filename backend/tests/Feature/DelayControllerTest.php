<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Mocks\DelayMock;
use Tests\Mocks\UserMock;
use Tests\TestCase;
use Tests\Traits\UseHeaders;
use Tests\Traits\UsePermissions;
use Tests\Traits\UseRoles;

class DelayControllerTest extends TestCase
{
    use RefreshDatabase,
        UseHeaders,
        UseRoles,
        UsePermissions;

    public array $permissions = [
        'delays.list',
        'delays.create',
        'delays.show',
        'delays.update',
        'delays.destroy'
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

    public function testAdminCanListDelays(): void
    {
        $admin = UserMock::create();
        $admin->assignRole('admin');

        $headers = $this->getHeadersForUser($admin);
        $this->withHeaders($headers)
            ->getJson('api/delays')
            ->assertHeader('content-type', 'application/json')
            ->assertOk();
    }

    public function testAdminCanCreateDelay(): void
    {
        $admin = UserMock::create();
        $admin->assignRole('admin');

        $headers = $this->getHeadersForUser($admin);

        $data = DelayMock::make()->toArray();

        $this->withHeaders($headers)
            ->postJson('api/delays', $data)
            ->assertHeader('content-type', 'application/json')
            ->assertCreated();

        $this->assertDatabaseHas('delays', [
            'description' => $data['description'],
        ]);
    }

    public function testAdminCanFindDelay(): void
    {
        $admin = UserMock::create();
        $admin->assignRole('admin');

        $headers = $this->getHeadersForUser($admin);

        $delay = DelayMock::create();

        $this->withHeaders($headers)
            ->getJson("api/delays/{$delay->id}")
            ->assertHeader('content-type', 'application/json')
            ->assertOk();
    }

    public function testAdminCanUpdateDelay(): void
    {
        $admin = UserMock::create();
        $admin->assignRole('admin');

        $headers = $this->getHeadersForUser($admin);

        $delay = DelayMock::create();
        $data = DelayMock::make()->toArray();

        $this->withHeaders($headers)
            ->putJson("api/delays/{$delay->id}", $data)
            ->assertHeader('content-type', 'application/json')
            ->assertOk();

        $this->assertDatabaseHas('delays', [
            'description' => $data['description'],
        ]);
    }

    public function testAdminCanDeleteDelay(): void
    {
        $admin = UserMock::create();
        $admin->assignRole('admin');

        $headers = $this->getHeadersForUser($admin);

        $delay = DelayMock::create();

        $this->withHeaders($headers)
            ->deleteJson("api/delays/{$delay->id}")
            ->assertNoContent();

        $this->assertDatabaseMissing('delays', [
            'id' => $delay->id,
        ]);
    }
}
