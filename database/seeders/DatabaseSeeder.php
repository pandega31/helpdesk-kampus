<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Ticket;
use App\Models\TicketReply;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Akun tetap untuk login dan demo
        $akun = [
            ['name' => 'Admin Helpdesk', 'email' => 'admin@helpdesk.test',      'role' => 'admin'],
            ['name' => 'Petugas Satu',   'email' => 'petugas@helpdesk.test',    'role' => 'petugas'],
            ['name' => 'Mahasiswa Satu', 'email' => 'mahasiswa1@helpdesk.test', 'role' => 'mahasiswa'],
            ['name' => 'Mahasiswa Dua',  'email' => 'mahasiswa2@helpdesk.test', 'role' => 'mahasiswa'],
        ];

        foreach ($akun as $a) {
            User::create($a + ['password' => Hash::make('password')]);
        }

        foreach (['Fasilitas', 'Jaringan', 'Akademik', 'Lainnya'] as $nama) {
            Category::create(['nama' => $nama]);
        }

        // Data dummy
        User::factory()->count(6)->create();

        $mahasiswa  = User::where('role', 'mahasiswa')->get();
        $categories = Category::all();
        $petugas    = User::where('role', 'petugas')->first();

        $tickets = Ticket::factory()
            ->count(30)
            ->recycle($mahasiswa)
            ->recycle($categories)
            ->create();

        foreach ($tickets as $ticket) {
            $jumlah = $ticket->status === 'open' ? 0 : fake()->numberBetween(1, 4);

            for ($i = 0; $i < $jumlah; $i++) {
                $pengirim = $i % 2 === 0 ? $petugas : $ticket->user;

                TicketReply::factory()->create([
                    'ticket_id'  => $ticket->id,
                    'user_id'    => $pengirim->id,
                    'created_at' => $ticket->created_at->copy()->addHours($i + 1),
                ]);
            }
        }
    }
}