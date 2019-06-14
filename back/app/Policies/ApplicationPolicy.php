<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\Application;
use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApplicationPolicy
{
    use HandlesAuthorization;

    public function before(User $current_user, $ability)
    {
        // Grant everything to developers, administrators and staffs
        if ($current_user->role()->isInferiorTo(Role::STAFF) && $ability != 'destroy') {
            return false;
        }
    }

    public function indexStatus(User $current_user)
    {
        return true;
    }

    public function update(User $current_user, Application $application)
    {
        // Impossible to update an application if the step of the project is
        // different than 'hiring'
        return $application->mission->project->step == Project::HIRING;
    }

    public function destroy(User $current_user, Application $application)
    {
        // $user1 whose $role < 'staff' can't delete the $application of $user2
        // unless   $user1 == $application->user
        return $current_user->is($application->user);
    }
}
