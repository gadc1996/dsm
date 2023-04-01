<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DelayPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('delays.list');
    }

    public function view(User $user)
    {
        return $user->hasPermissionTo('delays.show');
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo('delays.create');
    }

    public function update(User $user)
    {
        return $user->hasPermissionTo('delays.update');
    }

    public function delete(User $user)
    {
        return $user->hasPermissionTo('delays.destroy');
    }
}
