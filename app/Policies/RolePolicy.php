<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Role $role
     *
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->hasPermissionTo('read-roles');
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
        return $user->hasPermissionTo('create-roles');
    }

    /**
     * Determine whether the user can update the model.
     * A user cannot edit or update their role.
     *
     * @param User $user
     * @param Role $role
     *
     * @return mixed
     */
    public function update(User $user, Role $role)
    {
        if ($user->getRoleNames()->contains($role->name)) {
            return false;
        }

        return $user->hasPermissionTo('update-roles');
    }

    /**
     * Determine whether the user can delete the model.
     * A user cannot delete their role.
     *
     * @param User $user
     * @param Role $role
     *
     * @return mixed
     */
    public function delete(User $user, Role $role)
    {
        if ($user->getRoleNames()->contains($role->name)) {
            return false;
        }

        return $user->hasPermissionTo('delete-roles');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Role $role
     *
     * @return mixed
     */
    public function forceDelete(User $user, Role $role)
    {
    }
}
