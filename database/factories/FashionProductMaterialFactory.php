<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\FashionProductMaterial;
use Faker\Generator as Faker;

$factory->define(FashionProductMaterial::class, function (Faker $faker) {
    $materials = collect(preg_split('/(?=[A-Z])/', 'CanvasCashmereCottonFurHornJeans fabricJerseyLeatherLinenMixed fabricOther materialPatent leatherPolyesterSilkSuedeSyntheticsViscoseWoolCanvasCottonHornJeans fabricLeatherMixed fabricOther materialPatent leatherSilkSuede'))
        ->unique()
        ->filter(function ($material) {
            return !empty($material);
        });

    return [
        'name' => $materials->random(),
    ];
});
