<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Settings;
use App\Models\SettingType;
use Faker\Generator as Faker;

$factory->define(Settings::class, function (Faker $faker) {
    return [
        'setting_type_id' => function () {
            return factory(SettingType::class)->create()->id;
        },
        'name'  => $faker->words($nb = 2, $asText = true),
        'value' => $faker->text,
    ];
});
