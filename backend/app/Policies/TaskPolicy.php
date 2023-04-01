<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('tasks.list');
    }

    public function view(User $user)
    {
        return $user->hasPermissionTo('tasks.show');
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo('tasks.create');
    }

    public function update(User $user)
    {
        return $user->hasPermissionTo('tasks.update');
    }

    public function delete(User $user)
    {
        return $user->hasPermissionTo('tasks.destroy');
    }
}
