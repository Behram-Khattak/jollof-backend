<?php

use App\Models\Settings;
use App\Models\SettingType;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $types = SettingType::all();

        $types->each(function ($type) {
            factory(Settings::class, 10)->create(['setting_type_id' => $type->id]);
        });
    }
}
