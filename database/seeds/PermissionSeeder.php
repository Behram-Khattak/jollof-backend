<?php

// use App\Models\Permission;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // $permissions = Permission::PERMISSIONS;
        // $abilities = ['create', 'read', 'update', 'delete'];

        // foreach ($permissions as $permission) {
        //     $class = Str::plural(strtolower(class_basename($permission)));
        //     foreach ($abilities as $ability) {
        //         Permission::firstOrCreate(
        //             ['name' => Str::slug("{$ability} {$class}")],
        //             ['name' => "{$ability} {$class}", 'guard_name' => '*']
        //         );
        //     }
        // }

        $permissions = config('data.permissions');

        foreach($permissions as $permission){
            Permission::updateOrcreate(['name'=>$permission,'guard_name'=>'*']);
        }
    }
}
