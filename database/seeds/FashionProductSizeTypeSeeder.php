<?php

use Illuminate\Database\Seeder;

class FashionProductSizeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $types = \App\Enums\FashionProductSizeType::toArray();

        foreach ($types as $key => $value) {
            \App\Models\FashionProductSizeType::create(['name' => $value]);
        }
    }
}
