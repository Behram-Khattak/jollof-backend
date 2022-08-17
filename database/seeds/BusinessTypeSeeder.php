<?php

use App\Models\BusinessType;
use Illuminate\Database\Seeder;

class BusinessTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $businessTypes = ['Cuisine', 'Fashion', 'Lifestyle', 'Scholar', 'Business', 'Gift Portal'];

        foreach ($businessTypes as $businessType) {
            factory(BusinessType::class)->create(['name' => $businessType]);
        }
    }
}
