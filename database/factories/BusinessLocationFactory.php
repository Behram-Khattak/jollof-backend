<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Business;
use App\Models\BusinessLocation;
use Faker\Generator as Faker;

$factory->define(BusinessLocation::class, function (Faker $faker) {
    return [
        'business_id' => factory(Business::class),
        'telephone'   => $faker->e164PhoneNumber,
        'whatsapp'    => $faker->e164PhoneNumber,
        'state'       => $faker->city,
        'city'        => $faker->city,
        'area'        => $faker->streetName,
        'address'     => $faker->streetAddress,
    ];
});

$factory->state(BusinessLocation::class, 'hq', [
    'default' => true,
]);
