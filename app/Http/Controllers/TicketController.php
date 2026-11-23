<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTicketRequest;
use App\Models\Category;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $tickets = Ticket::with(['user', 'category'])
            ->when(! $user->isStaff(), fn ($q) => $q->where('user_id', $user->id))
            ->when($request->filled('q'), fn ($q) => $q->where('judul', 'like', '%' . $request->q . '%'))
            ->when($request->filled('category_id'), fn ($q) => $q->where('category_id', $request->category_id))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $categories = Category::orderBy('nama')->get();

        return view('tickets.index', compact('tickets', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('nama')->get();

        return view('tickets.create', compact('categories'));
    }

    public function store(StoreTicketRequest $request)
    {
        $ticket = $request->user()->tickets()->create($request->validated());

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Tiket berhasil dibuat.');
    }

    public function show(Request $request, Ticket $ticket)
    {
        abort_unless($ticket->isViewableBy($request->user()), 403);

        $ticket->load(['user', 'category', 'replies.user']);

        return view('tickets.show', compact('ticket'));
    }
}