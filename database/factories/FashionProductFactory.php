<?php

/** @var Factory $factory */

use App\Models\Business;
use App\Models\Category;
use App\Models\FashionProduct;
use App\Models\FashionProductColor;
use App\Models\FashionProductMaterial;
use App\Models\FashionProductSizeType;
use App\Models\FashionProductSizeValue;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(FashionProduct::class, function (Faker $faker) {
    return [
        'business_id'   => factory(Business::class),
        'category_id'   => factory(Category::class),
        'material_id'   => factory(FashionProductMaterial::class),
        'color_id'      => factory(FashionProductColor::class),
        'size_type_id'  => factory(FashionProductSizeType::class),
        'size_value_id' => factory(FashionProductSizeValue::class),
        'name'          => $faker->words(5, true),
        'description'   => $faker->text(240),
        'quantity'      => $quantity = $faker->randomDigitNotNull,
        'price'         => $faker->randomFloat(2, 1000, 6000),
        'weight'        => $faker->randomFloat(2, 0.1, 1),
        'is_available'  => $quantity > 0 ? true : false,
    ];
});

$factory->state(FashionProduct::class, 'discount', function (Faker $faker) {
    return [
        'sales_price' => $faker->randomFloat(2, 500, 5000),
        'sales_start' => now()->addRealDay(),
        'sales_end'   => now()->addRealDays(35),
    ];
});
