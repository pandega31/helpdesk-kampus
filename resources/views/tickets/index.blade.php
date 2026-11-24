@extends('layouts.app')

@section('title', 'Daftar Tiket')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">{{ auth()->user()->isStaff() ? 'Daftar Tiket' : 'Tiket Saya' }}</h1>
        <a href="{{ route('tickets.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Buat Tiket
        </a>
    </div>

    <form method="GET" action="{{ route('tickets.index') }}" class="card card-body mb-3">
        <div class="row g-2">
            <div class="col-4">
                <input type="search" name="q" value="{{ request('q') }}"
                       class="form-control" placeholder="Cari judul tiket...">
            </div>
            <div class="col-3">
                <select name="category_id" class="form-select">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>
                            {{ $category->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-3">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    @foreach (\App\Models\Ticket::STATUS as $status)
                        <option value="{{ $status }}" @selected(request('status') === $status)>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-2 d-grid">
                <button class="btn btn-outline-primary">Filter</button>
            </div>
        </div>
    </form>

    <div class="card">
        <table class="table table-hover mb-0 align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Judul Keluhan</th>
                    @if (auth()->user()->isStaff())
                        <th>Pelapor</th>
                    @endif
                    <th>Kategori</th>
                    <th>Prioritas</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tickets as $ticket)
                    <tr>
                        <td>#{{ $ticket->id }}</td>
                        <td>{{ $ticket->judul }}</td>
                        @if (auth()->user()->isStaff())
                            <td>{{ $ticket->user->name }}</td>
                        @endif
                        <td>{{ $ticket->category->nama }}</td>
                        <td><span class="badge badge-{{ $ticket->prioritas }}">{{ ucfirst($ticket->prioritas) }}</span></td>
                        <td><span class="badge badge-{{ $ticket->status }}">{{ ucfirst($ticket->status) }}</span></td>
                        <td>
                            <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-sm btn-primary">Buka</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Belum ada tiket.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $tickets->links() }}
    </div>
@endsection