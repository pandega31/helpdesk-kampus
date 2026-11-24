@extends('layouts.app')

@section('title', 'Tiket #' . $ticket->id)

@section('content')
    @php $user = auth()->user(); @endphp

    <nav class="small text-muted mb-2">
        <a href="{{ route('dashboard') }}" class="text-decoration-none">Dashboard</a> /
        <a href="{{ route('tickets.index') }}" class="text-decoration-none">Daftar Tiket</a> /
        Tiket #{{ $ticket->id }}
    </nav>

    <div class="d-flex justify-content-between align-items-start mb-3">
        <h1 class="h3 mb-0">{{ $ticket->judul }}</h1>
        <div>
            <span class="badge badge-{{ $ticket->prioritas }}">{{ ucfirst($ticket->prioritas) }}</span>
            <span class="badge badge-{{ $ticket->status }}">{{ ucfirst($ticket->status) }}</span>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-8">
            <div class="card card-body mb-3">
                {{-- Pesan pertama: deskripsi dari pelapor --}}
                <div class="bubble">
                    <div class="bubble-meta">
                        {{ $ticket->user->name }} (Pelapor) &middot; {{ $ticket->created_at->format('d M Y, H:i') }}
                    </div>
                    <div class="bubble-body">{{ $ticket->deskripsi }}</div>
                </div>

                @foreach ($ticket->replies as $reply)
                    <div class="bubble {{ $reply->user->isStaff() ? 'bubble-staff' : '' }}">
                        <div class="bubble-meta">
                            {{ $reply->user->name }}
                            ({{ $reply->user->isStaff() ? 'Petugas' : 'Mahasiswa' }})
                            &middot; {{ $reply->created_at->format('d M Y, H:i') }}
                        </div>
                        <div class="bubble-body">{{ $reply->isi }}</div>
                    </div>
                @endforeach
            </div>

            @if (! $user->isStaff() && $ticket->status === 'selesai')
                <div class="alert alert-secondary">Tiket ini sudah selesai dan tidak bisa dibalas lagi.</div>
            @else
                <div class="card card-body">
                    <h2 class="h6">Balas Pesan</h2>
                    <form action="{{ route('tickets.replies.store', $ticket) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <textarea name="isi" rows="4"
                                      class="form-control @error('isi') is-invalid @enderror"
                                      placeholder="Tulis balasan...">{{ old('isi') }}</textarea>
                            @error('isi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if ($user->isStaff())
                            <div class="row mb-3 align-items-center">
                                <label for="status" class="col-auto col-form-label">Ubah Status:</label>
                                <div class="col-4">
                                    <select name="status" id="status" class="form-select">
                                        @foreach (\App\Models\Ticket::STATUS as $status)
                                            <option value="{{ $status }}"
                                                @selected(old('status', $ticket->status) === $status)>
                                                {{ ucfirst($status) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif

                        <button type="submit" class="btn btn-primary">Kirim Balasan</button>
                    </form>
                </div>
            @endif
        </div>

        <div class="col-4">
            <div class="card card-body">
                <h2 class="h6 mb-3">Informasi Tiket</h2>
                <dl class="mb-0 small">
                    <dt class="text-muted">Kategori</dt>
                    <dd>{{ $ticket->category->nama }}</dd>
                    <dt class="text-muted">Tanggal</dt>
                    <dd>{{ $ticket->created_at->format('d M Y') }}</dd>
                    <dt class="text-muted">Pelapor</dt>
                    <dd class="mb-0">{{ $ticket->user->name }}</dd>
                </dl>
            </div>
        </div>

        <div class="card card-body mt-3">
            <h2 class="h6 mb-3">Riwayat Status</h2>
            @php $label = ['open' => 'Dibuat', 'proses' => 'Diproses', 'selesai' => 'Selesai']; @endphp

            <ul class="timeline small mb-0">
                @forelse ($ticket->statusLogs as $log)
                    <li>
                        <strong>{{ $label[$log->status] }}</strong>
                        <div class="text-muted">{{ $log->user->name }}</div>
                        <div class="text-muted">{{ $log->created_at->format('d M Y, H:i') }}</div>
                    </li>
                @empty
                    <li class="text-muted">Belum ada riwayat.</li>
                @endforelse
            </ul>
        </div>
    </div>
@endsection