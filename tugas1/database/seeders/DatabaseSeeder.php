<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'username' => 'Salman',
            'nama_lengkap' => 'Salman alfarisi firdaus',
            'password' => Hash::make('123qwerty'),
        ]);

        User::create([
            'username' => 'kevin',
            'nama_lengkap' => 'kevin akbar dermawan',
            'password' => Hash::make('qwerty123'),
        ]);
    }
}