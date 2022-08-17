<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        User::truncate();

        DB::table('model_has_roles')->truncate();

        factory(User::class)
            ->create(['username' => 'superadmin', 'email' => 'superadmin@jollof.com'])
            ->assignRole('super-admin');

        factory(User::class)
            ->create(['username' => 'admin', 'email' => 'admin@jollof.com'])
            ->assignRole('admin');

        // Role::where('name', '!=', 'super-admin')
        //     ->where('name', '!=', 'admin')
        //     ->get()
        //     ->each(function ($role) {
        //         factory(User::class, 3)
        //             ->create()
        //             ->each(function ($user) use ($role) {
        //                 // @var User $user
        //                 $user->assignRole($role);
        //             });
        //     });
    }
}
