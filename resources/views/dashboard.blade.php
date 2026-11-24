@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h1 class="h3 mb-1">Dashboard</h1>
    <p class="text-muted">Ringkasan dan aktivitas tiket terbaru.</p>

    @if ($error)
        <div class="alert alert-warning">{{ $error }}</div>
    @else
        @php
            $cards = [
                ['Total Tiket', 'total_tiket', 'bi-file-earmark-text', '#dbeafe', '#1d4ed8'],
                ['Open',        'open',        'bi-envelope-open',     '#e0e7ff', '#4338ca'],
                ['Proses',      'proses',      'bi-hourglass-split',   '#fef3c7', '#b45309'],
                ['Selesai',     'selesai',     'bi-check-circle',      '#dcfce7', '#15803d'],
            ];
        @endphp

        <div class="row g-3 mb-4">
            @foreach ($cards as [$label, $key, $icon, $bg, $fg])
                <div class="col-3">
                    <div class="card card-body d-flex flex-row align-items-center gap-3">
                        <div class="stat-icon" style="background: {{ $bg }}; color: {{ $fg }};">
                            <i class="bi {{ $icon }}"></i>
                        </div>
                        <div>
                            <div class="text-muted small">{{ $label }}</div>
                            <div class="fs-3 fw-bold">{{ $stats[$key] }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h2 class="h6 mb-0">Tiket Masuk Terbaru</h2>
                <a href="{{ route('tickets.index') }}" class="small">Lihat semua</a>
            </div>
            <table class="table table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Prioritas</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recent as $ticket)
                        <tr>
                            <td>#{{ $ticket['id'] }}</td>
                            <td>{{ $ticket['judul'] }}</td>
                            <td>{{ $ticket['kategori']['nama'] }}</td>
                            <td><span class="badge badge-{{ $ticket['prioritas'] }}">{{ ucfirst($ticket['prioritas']) }}</span></td>
                            <td><span class="badge badge-{{ $ticket['status'] }}">{{ ucfirst($ticket['status']) }}</span></td>
                            <td>{{ \Carbon\Carbon::parse($ticket['dibuat'])->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Belum ada tiket.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif
@endsection