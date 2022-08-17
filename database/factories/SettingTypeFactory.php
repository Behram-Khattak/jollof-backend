<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\SettingType;
use Faker\Generator as Faker;

$factory->define(SettingType::class, function (Faker $faker) {
    return [
        'name'  => $faker->randomElement(SettingType::NAMES),
    ];
});
