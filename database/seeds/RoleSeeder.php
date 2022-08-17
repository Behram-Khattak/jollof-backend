<?php

use App\Enums\DefaultRoles;
use App\Enums\RoleTypes;
use App\Enums\TeamRoles;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        app()['cache']->forget('spatie.permission.cache');

        foreach (DefaultRoles::toArray() as $key => $role) {
            Role::updateOrcreate([
                'name' => $role,
                'type' => RoleTypes::DEFAULT,
            ]);
        }

        foreach (TeamRoles::toArray() as $key => $role) {
            Role::updateOrcreate([
                'name' => $role,
                'type' => RoleTypes::TEAM,
            ]);
        }

        Role::findByName(DefaultRoles::ADMIN)->givePermissionTo(Permission::all());
    }
}
