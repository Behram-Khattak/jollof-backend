<?php

use App\Models\SettingType;
use Illuminate\Database\Seeder;

class SettingTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $names = SettingType::NAMES;

        foreach ($names as $name) {
            factory(SettingType::class)->create(['name' => $name]);
        }
    }
}
