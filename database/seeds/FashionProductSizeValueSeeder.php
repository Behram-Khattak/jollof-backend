<?php

use Illuminate\Database\Seeder;

class FashionProductSizeValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $string = 'Extra Extra Small, Extra Small, Small, Medium, Large,Extra Large, Extra Extra Large, 6,	7,	8,	9,	10,	11,	12,	7,	8,	9,	10,	11,	12,	13,	40,	41,	42,	43,	44,	45,	46, 4,	6,	8,	10,	12,	14,	16,	18,	20,	22,	24,	26,	32,	34,	36,	38,	40,	42,	44,46,48,	50,	52,	54,	1,	2,	4,	6,	8,	10,	12,	14,	16,	18,	20,	22,	4,	6,	8,	10,	12,	14,	16,18,	20,	22,	24,	26, 2,	3,	4,	5,	6,	7,	8, 33, 35,	36,	37';

        $sizes = collect(explode(',', $string));

        $sizes->each(function ($size) {
            \App\Models\FashionProductSizeValue::firstOrCreate(['name' => trim($size)]);
        });
    }
}
