<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'first_name'        => $faker->firstName,
        'last_name'         => $faker->lastName,
        'username'          => strtolower($faker->unique()->firstNameFemale),
        'email'             => $faker->unique()->safeEmail,
        'telephone'         => $faker->e164PhoneNumber,
        'email_verified_at' => $faker->randomElement([null, now()]),
        'password'          => Hash::make('password'),
        'remember_token'    => Str::random(10),
    ];
});
