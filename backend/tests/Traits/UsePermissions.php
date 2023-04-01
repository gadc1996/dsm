<?php

namespace Tests\Traits;

use Spatie\Permission\Models\Permission;

trait UsePermissions
{
  public function createPermissions(array $permissions): void
  {
    $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

    foreach ($permissions as $permission)
      Permission::firstOrCreate(['name' => $permission]);
  }
}
