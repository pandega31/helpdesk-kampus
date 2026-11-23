@extends('layouts.app')

@section('title', 'Keluhan Umum')

@section('content')
    <h1 class="h3 mb-1">Keluhan Umum</h1>
    <p class="text-muted">Daftar keluhan yang sudah dilaporkan. Cek di sini sebelum membuat tiket baru.</p>

    <form method="GET" action="{{ route('complaints.index') }}" class="card card-body mb-3">
        <div class="row g-2">
            <div class="col-5">
                <select name="category_id" class="form-select">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>
                            {{ $category->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-5">
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
                    <th>Judul Keluhan</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th style="width: 90px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($complaints as $complaint)
                    <tr>
                        <td>{{ $complaint->judul }}</td>
                        <td>{{ $complaint->category->nama }}</td>
                        <td><span class="badge badge-{{ $complaint->status }}">{{ ucfirst($complaint->status) }}</span></td>
                        <td>{{ $complaint->created_at->format('d M Y') }}</td>
                        <td>
                            @if ($complaint->isViewableBy(auth()->user()))
                                <a href="{{ route('tickets.show', $complaint) }}" class="btn btn-sm btn-primary">Lihat</a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Belum ada keluhan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $complaints->links() }}
    </div>
@endsection