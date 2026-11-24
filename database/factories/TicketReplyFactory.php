<?php

namespace Database\Factories;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketReplyFactory extends Factory
{
    public function definition(): array
    {
        return [
            'ticket_id' => Ticket::factory(),
            'user_id'   => User::factory(),
            'isi'       => fake()->randomElement([
                'Terima kasih atas laporannya, kami sedang memeriksa masalah ini.',
                'Teknisi akan datang besok pagi untuk menindaklanjuti.',
                'Masalah sudah diperbaiki, silakan dicek kembali.',
                'Masih bermasalah, mohon dicek ulang.',
            ]),
        ];
    }
}