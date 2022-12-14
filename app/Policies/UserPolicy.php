<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->hasPermissionTo('read-users');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create-users');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param User $routeUser
     *
     * @return mixed
     */
    public function update(User $user, User $routeUser)
    {
        return $user->hasPermissionTo('update-users');
    }
}
