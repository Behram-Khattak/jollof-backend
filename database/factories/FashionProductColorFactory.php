<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\FashionProductColor;
use Faker\Generator as Faker;

$factory->define(FashionProductColor::class, function (Faker $faker) {
    return [
        'name'     => $faker->unique(true)->colorName,
        'hex_code' => $faker->safeHexColor,
    ];
});
