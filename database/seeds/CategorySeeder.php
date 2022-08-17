<?php

use App\Models\BusinessType;
use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        BusinessType::where('slug', 'fashion')->first()->categories()->createMany([
            ['name' => "Women's Clothing"],
            ['name' => "Men's Clothing"],
            ['name' => 'Watches'],
            ['name' => 'Accessories'],
            ['name' => 'Jewelry'],
            ['name' => 'Shoes'],
            ['name' => 'Bags'],
            ['name' => 'Kids Fashion'],
            ]);

        Category::all()->each(function ($category) {
            switch ($category->name) {
                case "Women's Clothing":
                    $category->categories()->createMany([
                        ['name' => 'Tops'],
                        ['name' => "Women's Bottoms"],
                        ['name' => 'Wears'],
                    ]);
                    break;
                case "Men's Clothing":
                    $category->categories()->createMany([
                        ['name' => 'Clothing'],
                        ['name' => "Men's Bottoms"],
                    ]);
                    break;
                case 'Watches':
                    $category->categories()->createMany([
                        ['name' => "Women's Watches"],
                        ['name' => "Men's Watches"],
                    ]);
                    break;
                case 'Accessories':
                    $category->categories()->createMany([
                        ['name' => "Women's Accessories"],
                        ['name' => "Men's Accessories"],
                    ]);
                    break;
                case 'Jewelry':
                    $category->categories()->createMany([
                        ['name' => "Women's Jewelry"],
                        ['name' => "Men's Jewelry"],
                    ]);
                    break;
                case 'Shoes':
                    $category->categories()->createMany([
                        ['name' => "Women's Shoes"],
                        ['name' => "Men's Shoes"],
                    ]);
                    break;
                case 'Bags':
                    $category->categories()->createMany([
                        ['name' => "Women's bags"],
                    ]);
                    break;
                case 'Kids Fashion':
                    $category->categories()->createMany([
                        ['name' => "Boy's Clothing"],
                        ['name' => "Girl's Clothing"],
                        ['name' => "Boy's Shoes"],
                        ['name' => "Girl's Shoes"],
                        ['name' => "Boy's Accessories"],
                        ['name' => "Girl's Accessories"],
                    ]);
                    break;
            }
        });

        Category::whereNull('business_type_id')->get()->each(function ($category) {
            switch ($category->name) {
                case 'Tops':
                    $category->categories()->createMany([
                        ['name' => 'Dresses'],
                        ['name' => 'Blouses'],
                        ['name' => 'Suits'],
                        ['name' => 'Shirts'],
                        ['name' => 'Rompers'],
                    ]);
                    break;
                case "Women's Bottoms":
                    $category->categories()->createMany([
                        ['name' => 'Jeans'],
                        ['name' => 'Skirts'],
                        ['name' => 'Shorts'],
                        ['name' => 'Pants'],
                        ['name' => 'Leggings'],
                        ['name' => 'Underwear'],
                    ]);
                    break;
                case 'Wears':
                    $category->categories()->createMany([
                        ['name' => 'Jackets'],
                        ['name' => 'Pajamas'],
                    ]);
                    break;
                case 'Clothing':
                    $category->categories()->createMany([
                        ['name' => 'Shirts'],
                        ['name' => 'T-Shirts'],
                        ['name' => 'Polo Shirts'],
                        ['name' => 'Singlets'],
                        ['name' => 'Suits'],
                    ]);
                    break;
                case "Men's Bottoms":
                    $category->categories()->createMany([
                        ['name' => 'Trousers'],
                        ['name' => 'Jeans'],
                        ['name' => 'Underwear'],
                        ['name' => 'Shorts'],
                    ]);
                    break;
                case "Men's Watches":
                case "Women's Watches":
                    $category->categories()->createMany([
                        ['name' => 'Bracelet'],
                        ['name' => 'Leather'],
                        ['name' => 'Rubber'],
                        ['name' => 'Digital'],
                    ]);
                    break;
                case "Women's Accessories":
                    $category->categories()->createMany([
                        ['name' => 'Hats & Caps'],
                        ['name' => 'Sunglasses & Eyewear'],
                        ['name' => 'Scarves & Wraps'],
                        ['name' => 'Wallets, Card Cases & Money Organizers'],
                        ['name' => 'Belts'],
                        ['name' => 'Special Occasion'],
                        ['name' => 'Hair'],
                    ]);
                    break;
                case "Men's Accessories":
                    $category->categories()->createMany([
                        ['name' => 'Hats & Caps'],
                        ['name' => 'Sunglasses & Eyewear'],
                        ['name' => 'Neckties'],
                        ['name' => 'Wallets, Card Cases & Money Organizers'],
                        ['name' => 'Keyrings & Keychains'],
                        ['name' => 'Belts'],
                        ['name' => 'Cuff Links, Shirt Studs & Tie Clips'],
                        ['name' => 'Scarves'],
                        ['name' => 'Bow Ties & Cummerbunds'],
                        ['name' => 'Earmuffs'],
                        ['name' => 'Suspenders'],
                        ['name' => 'Socks'],
                    ]);
                    break;
                case "Women's Jewelry":
                    $category->categories()->createMany([
                        ['name' => 'Fashion'],
                        ['name' => 'Wedding & Engagement'],
                        ['name' => 'Fine'],
                    ]);
                    break;
                case "Men's Jewelry":
                    $category->categories()->createMany([
                        ['name' => 'Necklaces'],
                        ['name' => 'Bracelets'],
                        ['name' => 'Rings'],
                        ['name' => 'Wedding Rings'],
                        ['name' => 'Earrings'],
                    ]);
                    break;
                case "Women's Shoes":
                    $category->categories()->createMany([
                        ['name' => 'Fashion Sneakers'],
                        ['name' => 'Sandals'],
                        ['name' => 'Flats'],
                        ['name' => 'Pumps'],
                        ['name' => 'Slippers'],
                        ['name' => 'Sport Shoes'],
                        ['name' => 'Heels'],
                        ['name' => 'Athletic'],
                        ['name' => 'Boots'],
                        ['name' => 'Wedges'],
                        ['name' => 'Stilettos'],
                        ['name' => 'Outdoor'],
                        ['name' => 'Mid-calf boots'],
                        ['name' => 'Wellies'],
                        ['name' => 'Petite Sizes'],
                        ['name' => 'Mules & Clogs'],
                        ['name' => 'Loafers & Slip-Ons'],
                        ['name' => 'Casual Boots'],
                        ['name' => 'Sneakers & Canvas'],
                    ]);
                    break;
                case "Men's Shoes":
                    $category->categories()->createMany([
                        ['name' => 'Fashion Sneakers'],
                        ['name' => 'Loafers & Slip-Ons'],
                        ['name' => 'Sandals'],
                        ['name' => 'Outdoor'],
                        ['name' => 'Slippers'],
                        ['name' => 'Formal Shoes'],
                        ['name' => 'Athletic'],
                        ['name' => 'Boots'],
                        ['name' => 'Casual'],
                        ['name' => 'Espadrilles'],
                        ['name' => 'Oxfords'],
                        ['name' => 'Mules & Clogs'],
                    ]);
                    break;
                case "Women's bags":
                    $category->categories()->createMany([
                        ['name' => 'Cross-Body Bags'],
                        ['name' => 'Clutches'],
                        ['name' => 'Shoulder Bags'],
                        ['name' => 'Top-Handle Bags'],
                        ['name' => 'Handbags'],
                        ['name' => 'Purses'],
                        ['name' => 'Backpack Bags'],
                        ['name' => 'Wristlets'],
                        ['name' => 'Waist Bags'],
                    ]);
                    break;
                case "Boy's Clothing":
                    $category->categories()->createMany([
                        ['name' => 'Pants'],
                        ['name' => 'Tops & Tees'],
                        ['name' => 'Socks'],
                        ['name' => 'Suits & Sport Coats'],
                        ['name' => 'Jeans'],
                        ['name' => 'Sleepwear & Robes'],
                        ['name' => 'Underwear'],
                        ['name' => 'Shorts'],
                        ['name' => 'Jackets & Coats'],
                        ['name' => 'Fashion Hoodies & Sweatshirts'],
                    ]);
                    break;
                case "Girl's Clothing":
                    $category->categories()->createMany([
                        ['name' => 'Dresses'],
                        ['name' => 'Tops & Tees'],
                        ['name' => 'Underwear'],
                        ['name' => 'Jumpsuits & Rompers'],
                        ['name' => 'Jeans'],
                        ['name' => 'Swimwear'],
                        ['name' => 'Leggings'],
                        ['name' => 'Skirts, Scooters & Skorts'],
                        ['name' => 'Sleepwear & Robes'],
                        ['name' => 'Jackets & Coats'],
                        ['name' => 'Fashion Hoodies & Sweatshirts'],
                        ['name' => 'Shorts'],
                        ['name' => 'Sweaters'],
                        ['name' => 'Socks & Tights'],
                    ]);
                    break;
                case "Boy's Shoes":
                    $category->categories()->createMany([
                        ['name' => 'Sneakers'],
                        ['name' => 'Sandals'],
                        ['name' => 'Boots'],
                        ['name' => 'Athletic'],
                        ['name' => 'Slippers'],
                        ['name' => 'Clogs & Mules'],
                        ['name' => 'Oxfords'],
                        ['name' => 'School Shoes'],
                        ['name' => 'Loafers'],
                    ]);
                    break;
                case "Girl's Shoes":
                    $category->categories()->createMany([
                        ['name' => 'Sneakers'],
                        ['name' => 'Sandals'],
                        ['name' => 'Flats'],
                        ['name' => 'Boots'],
                        ['name' => 'Slippers'],
                        ['name' => 'Clogs & Mules'],
                        ['name' => 'Athletic'],
                    ]);
                    break;
                case "Boy's Accessories":
                    $category->categories()->createMany([
                        ['name' => 'Hats & Caps'],
                        ['name' => 'Sunglasses'],
                        ['name' => 'Belts'],
                        ['name' => 'Suspenders'],
                        ['name' => 'Cold Weather'],
                        ['name' => 'Neckties'],
                    ]);
                    break;
                case "Girl's Accessories":
                    $category->categories()->createMany([
                        ['name' => 'Hats & Caps'],
                        ['name' => 'Cold Weather'],
                        ['name' => 'Sunglasses'],
                        ['name' => 'Belts'],
                        ['name' => 'Bags'],
                    ]);
                    break;
            }
        });
    }
}
