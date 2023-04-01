<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Mocks\TaskMock;
use Tests\Mocks\UserMock;
use Tests\TestCase;
use Tests\Traits\UseHeaders;
use Tests\Traits\UsePermissions;
use Tests\Traits\UseRoles;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase,
        UseHeaders,
        UseRoles,
        UsePermissions;

    public array $permissions = [
        'tasks.list',
        'tasks.create',
        'tasks.show',
        'tasks.update',
        'tasks.destroy'
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

    public function testAdminCanListTasks(): void
    {
        $admin = UserMock::create();
        $admin->assignRole('admin');

        $headers = $this->getHeadersForUser($admin);
        $this->withHeaders($headers)
            ->getJson('api/tasks')
            ->assertHeader('content-type', 'application/json')
            ->assertOk();
    }

    public function testAdminCanCreateTask(): void
    {
        $admin = UserMock::create();
        $admin->assignRole('admin');

        $headers = $this->getHeadersForUser($admin);

        $assigne = UserMock::create();

        $data = TaskMock::make([
            'created_by_id' => $admin->id,
            'assigned_to_id' => $assigne->id,
        ])->toArray();

        $this->withHeaders($headers)
            ->postJson('api/tasks', $data)
            ->assertHeader('content-type', 'application/json')
            ->assertCreated();

        $this->assertDatabaseHas('tasks', [
            'description' => $data['description'],
            'created_by_id' => $data['created_by_id'],
            'assigned_to_id' => $data['assigned_to_id'],
        ]);
    }

    public function testAdminCanFindTask(): void
    {
        $admin = UserMock::create();
        $admin->assignRole('admin');

        $headers = $this->getHeadersForUser($admin);

        $task = TaskMock::create();

        $this->withHeaders($headers)
            ->getJson("api/tasks/{$task->id}")
            ->assertHeader('content-type', 'application/json')
            ->assertOk();
    }

    public function testAdminCanUpdateTask(): void
    {
        $admin = UserMock::create();
        $admin->assignRole('admin');

        $headers = $this->getHeadersForUser($admin);

        $task = TaskMock::create();
        $data = TaskMock::make()->toArray();

        $this->withHeaders($headers)
            ->putJson("api/tasks/{$task->id}", $data)
            ->assertHeader('content-type', 'application/json')
            ->assertOk();

        $this->assertDatabaseHas('tasks', [
            'description' => $data['description'],
            'assigned_to_id' => $data['assigned_to_id'],
        ]);
    }

    public function testAdminCanDeleteTask(): void
    {
        $admin = UserMock::create();
        $admin->assignRole('admin');

        $headers = $this->getHeadersForUser($admin);

        $task = TaskMock::create();

        $this->withHeaders($headers)
            ->deleteJson("api/tasks/{$task->id}")
            ->assertNoContent();

        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
        ]);
    }
}
