<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Admin Helpdesk',  'email' => 'admin@helpdesk.test',      'role' => 'admin'],
            ['name' => 'Petugas Satu',    'email' => 'petugas@helpdesk.test',    'role' => 'petugas'],
            ['name' => 'Mahasiswa Satu',  'email' => 'mahasiswa1@helpdesk.test', 'role' => 'mahasiswa'],
            ['name' => 'Mahasiswa Dua',   'email' => 'mahasiswa2@helpdesk.test', 'role' => 'mahasiswa'],
        ];

        foreach ($users as $user) {
            User::create($user + ['password' => Hash::make('password')]);
        }

        foreach (['Fasilitas', 'Jaringan', 'Akademik', 'Lainnya'] as $nama) {
            Category::create(['nama' => $nama]);
        }
    }
}