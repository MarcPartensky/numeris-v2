<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserRolePolicy
{
    use HandlesAuthorization;

    public function before(User $current_user, $ability)
    {
        // Grant everything to developers, administrators and staffs
        if ($current_user->role()->isInferiorTo(Role::STAFF) && $ability != 'index') {
            return false;
        }
    }

    public function index(User $current_user)
    {
        return $current_user->role()->isSuperiorTo(Role::STUDENT);
    }

    public function store(User $current_user, User $user, Role $role)
    {
        // Only $current_user->role >= $user->role can change $user->role
        // AND
        // $current_user->role >= $role
        return $current_user->role()->isSuperiorOrEquivalentTo($user->role()->name)
            && $current_user->role()->isSuperiorOrEquivalentTo($role->name);
    }
}
