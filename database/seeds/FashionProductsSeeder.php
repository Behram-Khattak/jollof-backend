<?php

use App\Enums\BusinessTypeEnum;
use App\Enums\MediaCollectionNames;
use App\Models\Business;
use App\Models\Category;
use App\Models\FashionProduct;
use App\Models\FashionProductColor;
use App\Models\FashionProductMaterial;
use App\Models\FashionProductSizeType;
use App\Models\FashionProductSizeValue;
use Illuminate\Database\Seeder;

class FashionProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $businesses = Business::whereHas('type', function ($query) {
            $query->where('name', BusinessTypeEnum::FASHION);
        })->get();

        $categories = Category::whereDoesntHave('childrenCategories')->get();

        $materials = FashionProductMaterial::all();

        $colors = FashionProductColor::all();

        $productSizeValues = FashionProductSizeValue::all();

        $productSizeTypes = FashionProductSizeType::all();

        $businesses->each(function ($business) use ($categories, $materials, $colors, $productSizeValues, $productSizeTypes) {
            factory(FashionProduct::class, 20)->create([
                'business_id'   => $business->id,
                'category_id'   => $categories->random()->id,
                'material_id'   => $materials->random()->id,
                'color_id'      => $colors->random()->id,
                'size_value_id' => $productSizeValues->random()->id,
                'size_type_id'  => $productSizeTypes->random()->id,
            ]);
            factory(FashionProduct::class, 20)->state('discount')->create([
                'business_id'   => $business->id,
                'category_id'   => $categories->random()->id,
                'material_id'   => $materials->random()->id,
                'color_id'      => $colors->random()->id,
                'size_value_id' => $productSizeValues->random()->id,
                'size_type_id'  => $productSizeTypes->random()->id,
            ]);
        });

        $featuredImages = Storage::files('public/sample/featured');
        $productImages = Storage::files('public/sample/images');

        FashionProduct::all()->each(function (FashionProduct $product) use ($featuredImages, $productImages) {
            foreach ($featuredImages as $image) {
                $product->addMedia(Storage::disk('local')->path($image))
                    ->preservingOriginal()
                    ->toMediaCollection(MediaCollectionNames::FEATURED_IMAGE);
            }

            foreach ($productImages as $image) {
                $product->addMedia(Storage::disk('local')->path($image))
                    ->preservingOriginal()
                    ->toMediaCollection(MediaCollectionNames::PRODUCT_IMAGES);
            }
        });
    }
}
