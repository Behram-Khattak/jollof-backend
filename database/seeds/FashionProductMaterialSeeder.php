<?php

use Illuminate\Database\Seeder;

class FashionProductMaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $string = 'CanvasCashmereCottonFurHornJeans fabricJerseyLeatherLinenMixed fabricOther materialPatent leatherPolyesterSilkSuedeSyntheticsViscoseWoolCanvasCottonHornJeans fabricLeatherMixed fabricOther materialPatent leatherSilkSuede';

        collect(preg_split('/(?=[A-Z])/', $string))
            ->unique()
            ->filter(function ($material) {
                return !empty($material);
            })
            ->each(function ($material) {
                App\Models\FashionProductMaterial::firstOrCreate(['name' => $material]);
            });
    }
}
