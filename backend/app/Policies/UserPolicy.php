<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('users.list');
    }

    public function view(User $user)
    {
        return $user->hasPermissionTo('users.show');
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo('users.create');
    }

    public function update(User $user)
    {
        return $user->hasPermissionTo('users.update');
    }

    public function delete(User $user)
    {
        return $user->hasPermissionTo('users.destroy');
    }
}
