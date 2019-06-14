<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    public function before(User $current_user, $ability)
    {
        // Grant everything to developers and administrators
        if ($current_user->role()->isSuperiorOrEquivalentTo(Role::ADMINISTRATOR)) {
            return true;
        }
    }

    public function index(User $current_user)
    {
        return false;
    }
}
