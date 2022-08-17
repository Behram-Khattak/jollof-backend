<?php

use App\Models\Bank;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $banks = json_decode(file_get_contents((base_path('database/data/banks.json'))), true);

        foreach ($banks['data'] as $bank) {
            Bank::create([
                'code' => $bank['nip_bank_code'],
                'name' => $bank['bank_name'],
            ]);
        }
    }
}
