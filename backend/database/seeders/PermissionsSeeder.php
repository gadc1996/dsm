<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    private $permissions = [
        'navigation.list',
        'roles.list',
        'dashboard.list',
        'users.list',
        'users.create',
        'users.show',
        'users.update',
        'users.destroy',
        'sales.list',
        'sales.create',
        'sales.show',
        'sales.update',
        'sales.destroy',
        'customers.list',
        'customers.create',
        'customers.show',
        'customers.update',
        'customers.destroy',
        'lessons.list',
        'lessons.create',
        'lessons.show',
        'lessons.update',
        'lessons.destroy',
        'lessons-plans.list',
        'lessons-plans.create',
        'lessons-plans.show',
        'lessons-plans.update',
        'lessons-plans.destroy',
        'reservations.list',
        'reservations.create',
        'reservations.show',
        'reservations.update',
        'reservations.destroy',
        'schedules.list',
        'schedules.create',
        'schedules.show',
        'schedules.update',
        'schedules.destroy',
        'concurrent-lesson-times.list',
        'concurrent-lesson-times.create',
        'concurrent-lesson-times.show',
        'concurrent-lesson-times.update',
        'concurrent-lesson-times.destroy'
        // new permission
    ];

    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        array_map(function (string $name) {
            Permission::firstOrCreate(['name' => $name]);
        }, $this->permissions);

        Role::firstOrCreate(['name' => 'admin'])->givePermissionTo(Permission::all());

        $admin = User::find(1);
        $admin->assignRole('admin');
    }
}
