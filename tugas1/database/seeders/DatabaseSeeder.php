<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin
        User::create([
            'username' => 'Salman',
            'nama_lengkap' => 'Salman alfarisi firdaus',
            'password' => Hash::make('123qwerty'),
            'role' => 'admin',
        ]);

        // 2. Akun Staff
        User::create([
            'username' => 'kevin',
            'nama_lengkap' => 'Kevin Akbar Dermawan',
            'password' => Hash::make('qwerty123'),
            'role' => 'staff',
        ]);

        // 3. Akun Customer
        User::create([
            'username' => 'budi',
            'nama_lengkap' => 'Budi Santoso',
            'password' => Hash::make('password123'),
            'role' => 'customer',
        ]);
    }
}