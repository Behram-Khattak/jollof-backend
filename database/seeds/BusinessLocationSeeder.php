<?php

use App\Models\Business;
use App\Models\BusinessLocation;
use App\Models\Restaurant;
use Illuminate\Database\Seeder;

class BusinessLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Business::all()->each(function ($business) {
            $businessLocation = factory(BusinessLocation::class)->states('hq')->create(['business_id' => $business->id]);
            if($businessLocation->id == 1){
                Restaurant::create([
                    'business_id' => $business->id,
                    'business_location_id' => $businessLocation->id,
                ]);
            }
        });
    }
}
