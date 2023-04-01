<?php

namespace Tests\Traits;

use Spatie\Permission\Models\Role;

trait UseRoles
{
    public function createRoles(array $roles): void
    {
        foreach ($roles as $role)
            Role::create(['name' => $role]);
    }

    public function givePermissionsToRole(array $permissions, string $role): void
    {
        Role::findByName($role)->givePermissionTo($permissions);
    }
}
