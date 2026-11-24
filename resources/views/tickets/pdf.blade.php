<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tiket #{{ $ticket->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #1e293b; }
        h1 { font-size: 18px; margin: 0 0 4px; }
        h2 { font-size: 14px; margin: 20px 0 8px; border-bottom: 1px solid #cbd5e1; padding-bottom: 4px; }
        table { width: 100%; border-collapse: collapse; }
        td, th { padding: 5px 6px; text-align: left; vertical-align: top; }
        .info td:first-child { width: 120px; color: #64748b; }
        .grid th { background: #f1f5f9; border-bottom: 1px solid #cbd5e1; }
        .grid td { border-bottom: 1px solid #e2e8f0; }
        .pesan { margin-bottom: 10px; padding: 8px; background: #f1f5f9; }
        .pesan.staf { background: #dbeafe; }
        .meta { color: #64748b; font-size: 10px; margin-bottom: 3px; }
        .footer { margin-top: 24px; font-size: 10px; color: #64748b; }
    </style>
</head>
<body>
    <h1>Helpdesk Kampus</h1>
    <div class="meta">Riwayat Tiket #{{ $ticket->id }}</div>

    <h2>{{ $ticket->judul }}</h2>
    <table class="info">
        <tr><td>Pelapor</td><td>{{ $ticket->user->name }}</td></tr>
        <tr><td>Kategori</td><td>{{ $ticket->category->nama }}</td></tr>
        <tr><td>Prioritas</td><td>{{ ucfirst($ticket->prioritas) }}</td></tr>
        <tr><td>Status</td><td>{{ ucfirst($ticket->status) }}</td></tr>
        <tr><td>Dibuat</td><td>{{ $ticket->created_at->format('d M Y, H:i') }}</td></tr>
    </table>

    <h2>Deskripsi Keluhan</h2>
    <div>{!! nl2br(e($ticket->deskripsi)) !!}</div>

    @if ($ticket->lampiran && file_exists(storage_path('app/public/' . $ticket->lampiran)))
        <div style="margin-top: 10px;">
            <img src="{{ storage_path('app/public/' . $ticket->lampiran) }}" style="max-width: 320px;">
        </div>
    @endif

    <h2>Riwayat Status</h2>
    <table class="grid">
        <thead>
            <tr><th>Status</th><th>Oleh</th><th>Waktu</th></tr>
        </thead>
        <tbody>
            @forelse ($ticket->statusLogs as $log)
                <tr>
                    <td>{{ ucfirst($log->status) }}</td>
                    <td>{{ $log->user->name }}</td>
                    <td>{{ $log->created_at->format('d M Y, H:i') }}</td>
                </tr>
            @empty
                <tr><td colspan="3">Belum ada riwayat.</td></tr>
            @endforelse
        </tbody>
    </table>

    <h2>Percakapan</h2>
    @forelse ($ticket->replies as $reply)
        <div class="pesan {{ $reply->user->isStaff() ? 'staf' : '' }}">
            <div class="meta">
                {{ $reply->user->name }}
                ({{ $reply->user->isStaff() ? 'Petugas' : 'Mahasiswa' }})
                &middot; {{ $reply->created_at->format('d M Y, H:i') }}
            </div>
            {!! nl2br(e($reply->isi)) !!}
        </div>
    @empty
        <p>Belum ada balasan.</p>
    @endforelse

    <div class="footer">
        Dicetak oleh {{ $dicetakOleh->name }} pada {{ now()->format('d M Y, H:i') }}
    </div>
</body>
</html>