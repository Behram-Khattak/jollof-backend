<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call(BankSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(BusinessTypeSeeder::class);
        //$this->call(BusinessSeeder::class);
        //$this->call(BusinessLocationSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(SettingTypeSeeder::class);
        $this->call(SettingsSeeder::class);
        $this->call(FashionProductMaterialSeeder::class);
        $this->call(FashionProductColorSeeder::class);
        $this->call(FashionProductSizeTypeSeeder::class);
        $this->call(FashionProductSizeValueSeeder::class);
        $this->call(StatesSeeder::class);
        $this->call(FashionProductsSeeder::class);
    }
}
