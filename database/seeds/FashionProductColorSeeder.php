<?php

use App\Models\FashionProductColor;
use Illuminate\Database\Seeder;

class FashionProductColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $colors = json_decode(file_get_contents((base_path('colors.json'))), true);

        foreach ($colors as $color) {
            FashionProductColor::create([
                'name'     => $color['name'],
                'hex_code' => $color['hex'],
            ]);
        }
    }
}
