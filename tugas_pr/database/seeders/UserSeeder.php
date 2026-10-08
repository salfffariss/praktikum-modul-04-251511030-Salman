<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'id_user' => 'USR001',
            'nama_lengkap' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'username' => 'budi',
            'password' => Hash::make('password123'),
            'no_hp' => '081234567890',
            'alamat' => 'Jl. Merdeka No. 10, Jakarta',
        ]);

        User::create([
            'id_user' => 'USR002',
            'nama_lengkap' => 'Ani Wijaya',
            'email' => 'ani@example.com',
            'username' => 'ani',
            'password' => Hash::make('password123'),
            'no_hp' => '089876543210',
            'alamat' => 'Jl. Sudirman No. 45, Bandung',
        ]);
    }
}
