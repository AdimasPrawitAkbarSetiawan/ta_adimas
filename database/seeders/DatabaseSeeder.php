<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Client;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name'     => 'Admin Sistem',
            'email'    => 'admin@sketsa.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        // Owner
        User::create([
            'name'     => 'Direktur Sketsa',
            'email'    => 'owner@sketsa.com',
            'password' => Hash::make('password'),
            'role'     => 'owner',
        ]);

        // Marketing
        User::create([
            'name'     => 'Budi Marketing',
            'email'    => 'marketing@sketsa.com',
            'password' => Hash::make('password'),
            'role'     => 'marketing',
        ]);

        // Operasional
        User::create([
            'name'     => 'Siti Operasional',
            'email'    => 'operasional@sketsa.com',
            'password' => Hash::make('password'),
            'role'     => 'operasional',
        ]);

        // Klien (user + data klien)
        $userKlien = User::create([
            'name'     => 'PT Maju Bersama',
            'email'    => 'klien@majubersama.com',
            'password' => Hash::make('password'),
            'role'     => 'klien',
        ]);

        Client::create([
            'user_id'      => $userKlien->id,
            'company_name' => 'PT Maju Bersama',
            'phone'        => '081234567890',
            'address'      => 'Jl. Sudirman No. 10, Jakarta',
        ]);
    }
}