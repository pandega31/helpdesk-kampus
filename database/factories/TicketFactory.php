<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    public function definition(): array
    {
        $dibuat = fake()->dateTimeBetween('-30 days', 'now');

        return [
            'user_id'     => User::factory(),
            'category_id' => Category::factory(),
            'judul'       => fake()->randomElement([
                'AC kelas tidak dingin',
                'WiFi lab komputer sering putus',
                'Proyektor ruang kuliah tidak menyala',
                'Tidak bisa login ke sistem akademik',
                'Kursi di ruang kelas patah',
                'Listrik di lab sering padam',
                'Nilai belum muncul di portal akademik',
                'Printer perpustakaan rusak',
            ]),
            'deskripsi'   => fake()->randomElement([
                'Masalah ini sudah terjadi sejak beberapa hari lalu dan mengganggu kegiatan belajar.',
                'Mohon segera ditindaklanjuti karena sangat mengganggu aktivitas di ruangan.',
                'Sudah dicoba beberapa kali tetapi masalahnya masih berulang.',
                'Kejadian ini muncul setiap pagi dan belum ada perbaikan sampai sekarang.',
            ]),
            'prioritas'   => fake()->randomElement(Ticket::PRIORITAS),
            'status'      => fake()->randomElement(Ticket::STATUS),
            'created_at'  => $dibuat,
            'updated_at'  => $dibuat,
        ];
    }
}