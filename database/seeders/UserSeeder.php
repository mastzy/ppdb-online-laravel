<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Account Admin
        User::create([
            'name' => 'Administrator PPDB',
            'email' => 'admin@ppdb.sch.id',
            'password' => Hash::make('password123'),
            'role' => 'admin', // REQ-AUTH-02
        ]);

        // Account Verifikator
        User::create([
            'name' => 'Panitia Verifikator',
            'email' => 'verifikator@ppdb.sch.id',
            'password' => Hash::make('password123'),
            'role' => 'verifikator', // REQ-AUTH-02
        ]);

        // Account Calon Siswa Contoh
        User::create([
            'name' => 'Calon Siswa Demo',
            'email' => 'siswa@ppdb.sch.id',
            'nik' => '3301000011223344', // REQ-AUTH-01 (16 digit)[cite: 3]
            'nisn' => '0012345678',      // REQ-AUTH-01 (10 digit)[cite: 3]
            'password' => Hash::make('password123'),
            'role' => 'siswa', // REQ-AUTH-02[cite: 3]
        ]);
    }
}