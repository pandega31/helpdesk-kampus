<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class TicketPdfController extends Controller
{
    public function __invoke(Request $request, Ticket $ticket)
    {
        abort_unless($ticket->isViewableBy($request->user()), 403);

        $ticket->load(['user', 'category', 'replies.user', 'statusLogs.user']);

        $pdf = Pdf::loadView('tickets.pdf', [
            'ticket'      => $ticket,
            'dicetakOleh' => $request->user(),
        ]);

        return $pdf->download('tiket-' . $ticket->id . '.pdf');
    }
}