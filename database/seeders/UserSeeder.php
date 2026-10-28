<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Administrator PPDB',
                'username' => 'admin',
                'email' => 'admin@ppdb.test',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ],
            [
                'name' => 'Panitia Verifikator Berkas',
                'username' => 'verifikator',
                'email' => 'verifikator@ppdb.test',
                'password' => Hash::make('password'),
                'role' => 'verifikator',
            ],
            [
                'name' => 'Bendahara & Kasir PPDB',
                'username' => 'bendahara',
                'email' => 'bendahara@ppdb.test',
                'password' => Hash::make('password'),
                'role' => 'bendahara',
            ],
            [
                'name' => 'Ustaz Penguji Diagnostik & BTQ',
                'username' => 'penguji',
                'email' => 'penguji@ppdb.test',
                'password' => Hash::make('password'),
                'role' => 'penguji',
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['username' => $userData['username']],
                $userData
            );
        }
    }
}
