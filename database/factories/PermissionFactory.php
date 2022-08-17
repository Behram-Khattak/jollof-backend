<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Permission;
use Faker\Generator as Faker;

$factory->define(Permission::class, function (Faker $faker) {
    return [
        'name'       => str_replace(' ', '-', $faker->words($nb = 2, $asText = true)),
        'guard_name' => '*',
    ];
});
