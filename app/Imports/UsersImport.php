<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToCollection;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Illuminate\Support\Facades\Storage;

class UsersImport implements ToCollection, WithHeadingRow, WithChunkReading, ShouldQueue
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            $validator = Validator::make($row->toArray(), [
                'first_name' => 'required|max:100',
                'last_name' => 'required|max:100',
                'email' => 'required|unique:users,email',
                'phone' => 'required|unique:users,telephone',

            ]);

            if ($validator->fails()) {
                Storage::disk('public')->append('errors.txt', 'Failed Or Exists' . $row);
            } else {

                $users = User::create([
                    'first_name' => $row['first_name'],
                    'last_name' => $row['last_name'],
                    'email' => $row['email'],
                    'telephone' => $row['phone'],
                    'email_verified_at' => '2018-05-05 12:16',
                    'password' => Hash::make('0912@eq'),
                ]);

                $users->assignRole('user');
            }
        }
    }

    public function chunkSize(): int
    {
        return 100;
    }
}
