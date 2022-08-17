<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Business;
use App\Models\BusinessType;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Business::class, function (Faker $faker) {
    return [
        'owner_id'         => factory(User::class),
        'business_type_id' => factory(BusinessType::class),
        'name'             => $name = $faker->company,
        'slug'             => \Illuminate\Support\Str::slug($name),
        'email'            => $faker->companyEmail,
        'telephone'        => $faker->e164PhoneNumber,
        'whatsapp'         => $faker->e164PhoneNumber,
        'description'      => $faker->sentence,
    ];
});
