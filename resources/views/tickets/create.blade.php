@extends('layouts.app')

@section('title', 'Buat Tiket Baru')

@section('content')
    <h1 class="h3 mb-3">Buat Tiket Baru</h1>

    <div class="row g-4">
        <div class="col-8">
            <div class="card card-body">
                <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul Keluhan</label>
                        <input type="text" name="judul" id="judul"
                               class="form-control @error('judul') is-invalid @enderror"
                               value="{{ old('judul') }}" placeholder="Contoh: AC Kelas 305 Rusak">
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="category_id" class="form-label">Kategori</label>
                            <select name="category_id" id="category_id"
                                    class="form-select @error('category_id') is-invalid @enderror">
                                <option value="">Pilih kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                        {{ $category->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label for="prioritas" class="form-label">Prioritas</label>
                            <select name="prioritas" id="prioritas"
                                    class="form-select @error('prioritas') is-invalid @enderror">
                                @foreach (\App\Models\Ticket::PRIORITAS as $prioritas)
                                    <option value="{{ $prioritas }}"
                                        @selected(old('prioritas', 'sedang') === $prioritas)>
                                        {{ ucfirst($prioritas) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('prioritas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Keluhan</label>
                        <textarea name="deskripsi" id="deskripsi" rows="6"
                                  class="form-control @error('deskripsi') is-invalid @enderror"
                                  placeholder="Jelaskan keluhan secara rinci...">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="lampiran" class="form-label">Lampiran Foto (opsional)</label>
                        <input type="file" name="lampiran" id="lampiran" accept="image/png,image/jpeg"
                            class="form-control @error('lampiran') is-invalid @enderror">
                        <div class="form-text">Format JPG atau PNG, maksimal 2 MB.</div>
                        @error('lampiran')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Kirim Tiket</button>
                    <a href="{{ route('tickets.index') }}" class="btn btn-outline-secondary">Batal</a>
                </form>
            </div>
        </div>

        <div class="col-4">
            <div class="card card-body">
                <h2 class="h6">Tips Melaporkan Keluhan</h2>
                <ol class="small text-muted ps-3 mb-0">
                    <li class="mb-2">Tulis judul yang singkat dan jelas, sebutkan lokasi atau layanan yang bermasalah.</li>
                    <li class="mb-2">Jelaskan kapan masalah mulai terjadi dan apa yang sudah kamu coba.</li>
                    <li>Pilih kategori dan prioritas yang sesuai agar tiket cepat ditangani.</li>
                </ol>
            </div>
        </div>
    </div>
@endsection