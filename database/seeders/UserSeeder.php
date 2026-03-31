<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nama_lengkap' => 'Administrator Sistem',
            'username' => 'admin',
            'password' => bcrypt('111111'),
            'role' => 'admin',
        ]);

        user::create([
            'nama_lengkap' => 'Petugas Sistem',
            'username' => 'petugas',
            'password' => bcrypt('111111'),
            'role' => 'petugas',
        ]);

        user::create([
            'nama_lengkap' => 'Owner Sistem',
            'username' => 'owner',
            'password' => bcrypt('111111'),
            'role' => 'owner',
        ]);
    }
}
