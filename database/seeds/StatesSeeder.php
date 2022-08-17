<?php

use App\Models\Areas;
use App\Models\Permission;
use App\Models\States;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class StatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $all = States::all();
        if (!$all->isEmpty()) {
            return false;
        }

        $data = json_decode(File::get('states.json'), true);
        foreach ($data as $d) {
            $dbData = [
                'state'  => $d['state'],
                'status' => ($d['state'] == 'Lagos') ? 'active' : 'inactive',
            ];

            $state = States::create($dbData);

            if ($d['state'] == 'Lagos') {
                foreach ($d['lgas'] as $lga) {
                    foreach ($lga as $key => $areas) {
                        foreach ($areas as $area) {
                            $lgaData = [
                                'states_id' => $state->id,
                                'area'      => "{$key} - {$area}",
                                'status'    => 'active',
                            ];

                            Areas::create($lgaData);
                        }
                    }
                }
            } else {
                foreach ($d['lgas'] as $lga) {
                    $lgaData = [
                        'states_id' => $state->id,
                        'area'      => $lga,
                        'status'    => 'inactive',
                    ];
                    Areas::create($lgaData);
                }
            }
        }

        return States::with('areas')->get();
    }
}
