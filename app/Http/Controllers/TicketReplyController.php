<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReplyRequest;
use App\Models\Ticket;

class TicketReplyController extends Controller
{
    public function store(StoreReplyRequest $request, Ticket $ticket)
    {
        $user = $request->user();

        abort_unless($ticket->isViewableBy($user), 403);
        abort_if(! $user->isStaff() && $ticket->status === 'selesai', 403, 'Tiket sudah selesai.');

        $ticket->replies()->create([
            'user_id' => $user->id,
            'isi'     => $request->validated('isi'),
        ]);

        if ($user->isStaff() && $request->filled('status') && $request->status !== $ticket->status) {
            $ticket->update(['status' => $request->status]);

            $ticket->statusLogs()->create([
                'user_id' => $user->id,
                'status'  => $request->status,
            ]);
        }

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Balasan berhasil dikirim.');
    }
}