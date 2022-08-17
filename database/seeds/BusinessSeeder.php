<?php

use App\Enums\MediaCollectionNames;
use App\Models\Business;
use App\Models\BusinessType;
use App\Models\User;
use Illuminate\Database\Seeder;

class BusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $users = User::role('merchant')->get();

        BusinessType::all()->each(function ($businessType) use ($users) {
            $businesses = factory(Business::class, 3)->create([
                'owner_id'         => $users->random()->id,
                'business_type_id' => $businessType->id,
            ]);

            $logos = Storage::files('public/sample/logo');

            $businesses->each(function ($business) use ($logos) {
                // @var Business $business
                foreach ($logos as $logo) {
                    $business->addMedia(Storage::disk('local')->path($logo))
                        ->preservingOriginal()
                        ->toMediaCollection(MediaCollectionNames::LOGO);
                }
            });

            $banners = Storage::files('public/sample/banner');

            $businesses->each(function (Business $business) use ($banners) {
                foreach ($banners as $banner) {
                    $business->addMedia(Storage::disk('local')->path($banner))
                        ->preservingOriginal()
                        ->toMediaCollection(MediaCollectionNames::BANNER);
                }
            });

            $kycs = Storage::files('public/sample/kyc');

            $businesses->each(function (Business $business) use ($kycs) {
                foreach ($kycs as $kyc) {
                    $business->addMedia(Storage::disk('local')->path($kyc))
                        ->preservingOriginal()
                        ->toMediaCollection(MediaCollectionNames::KYC);
                }
            });
        });
    }
}
