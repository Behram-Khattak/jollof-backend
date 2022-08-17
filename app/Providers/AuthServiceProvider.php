<?php

namespace App\Providers;

use App\Models\Role;
use App\Models\Settings;
use App\Models\User;
use App\Policies\RolePolicy;
use App\Policies\SettingsPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Settings::class => SettingsPolicy::class,
        Role::class     => RolePolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Implicitly grant "Super Admin" role all permissions
        Gate::before(function ($user, $ability) {
            /** @var User $user */
            return $user->hasRole('super-admin') ? true : null;
        });
    }
}
