<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'name' => $faker->randomElement(['Shirts', 'T-Shirts', 'Polo Shirts', 'Singlets', 'Suits']),
    ];
});
