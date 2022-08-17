<?php

use App\Models\JollofUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class JollofUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $all = JollofUser::all();
        if (!$all->isEmpty()) {
            return false;
        }

        JollofUser::create([
            "first_name" => "Amaka",
            "last_name" => "Okonkwo",
            "email" => "okonkwouzoamaka100@yahoo.com",
            "phone" => "08099881122",
            "code" => Str::uuid(),
        ]);

        $data = json_decode(Storage::get('jollofusers.json'), true);

        foreach ($data as $d) {
            $d['code'] = Str::uuid();
            JollofUser::create($d);
        }
    }
}
