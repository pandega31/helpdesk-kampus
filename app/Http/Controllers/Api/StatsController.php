<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ticket;

class StatsController extends Controller
{
    public function __invoke()
    {
        $perStatus = Ticket::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return response()->json([
            'data' => [
                'total_tiket' => $perStatus->sum(),
                'open'        => $perStatus['open'] ?? 0,
                'proses'      => $perStatus['proses'] ?? 0,
                'selesai'     => $perStatus['selesai'] ?? 0,
            ],
        ]);
    }
}