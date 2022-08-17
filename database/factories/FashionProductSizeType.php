<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\FashionProductSizeType;
use Faker\Generator as Faker;

$factory->define(FashionProductSizeType::class, function (Faker $faker) {
    return [
        'name' => $faker->randomElement(\App\Enums\FashionProductSizeType::values()),
    ];
});
