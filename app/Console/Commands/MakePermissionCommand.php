<?php

namespace App\Console\Commands;

use App\Models\Permission;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MakePermissionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:permission {name} {--R|remove}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate CRUD permissions for a model';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $permissions = $this->generatePermissions();
        // check if its remove
        if ($option = $this->option('remove')) {
            // remove permission
            if (Permission::where('name', 'LIKE', '%'.$this->getNameArgument())->delete()) {
                $this->warn('Permissions '.implode(', ', $permissions).' deleted.');
            } else {
                $this->warn('No permissions for '.$this->getNameArgument().' found!');
            }
        } else {
            // create permissions
            foreach ($permissions as $permission) {
                Permission::firstOrCreate(
                    ['name' => Str::slug($permission)],
                    ['name' => $permission, 'guard_name' => '*']
                );
            }

            $this->info('Permissions '.implode(', ', $permissions).' created.');
        }

        app()['cache']->forget('spatie.permission.cache');
    }

    private function generatePermissions()
    {
        $abilities = ['create', 'read', 'update', 'delete'];
        $name = $this->getNameArgument();

        return array_map(function ($val) use ($name) {
            return "{$val} {$name}";
        }, $abilities);
    }

    private function getNameArgument()
    {
        return strtolower(Str::plural($this->argument('name')));
    }
}
