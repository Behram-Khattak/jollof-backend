<?php

namespace App\Policies;

use App\Models\Settings;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SettingsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     *
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->hasPermissionTo('read-settings');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create-settings');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User     $user
     * @param \App\Models\Settings $settings
     *
     * @return mixed
     */
    public function update(User $user, Settings $settings)
    {
        return $user->hasPermissionTo('update-settings');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User     $user
     * @param \App\Models\Settings $settings
     *
     * @return mixed
     */
    public function delete(User $user, Settings $settings)
    {
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User     $user
     * @param \App\Models\Settings $settings
     *
     * @return mixed
     */
    public function restore(User $user, Settings $settings)
    {
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User     $user
     * @param \App\Models\Settings $settings
     *
     * @return mixed
     */
    public function forceDelete(User $user, Settings $settings)
    {
    }
}
