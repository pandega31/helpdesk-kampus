<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TicketResource;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $tickets = Ticket::with('category')
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->when($request->filled('category_id'), fn ($q) => $q->where('category_id', $request->category_id))
            ->latest()
            ->paginate(min($request->integer('per_page', 10), 50));

        return TicketResource::collection($tickets);
    }

    public function show(Ticket $ticket)
    {
        return new TicketResource($ticket->load('category'));
    }
}