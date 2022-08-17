<?php

use App\Models\Business;
use App\Models\Payout;
use Illuminate\Database\Seeder;

class PayoutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bizs = Business::all();
        if ($bizs->isEmpty()) {
            return false;
        }

        foreach($bizs as $b){
            $pay = Payout::where('business_id', $b->id)->first();
            if(!$pay){
                $nextPayout = date('Y-m-d', strtotime('+ 30 days'));
                Payout::create([

                    'frequency' => 'Monthly',
                    'next_payout' => $nextPayout,
                    'business_id' => $b->id,
                    'percentage' => '65'

                ]);
            }
        }
    }
}
