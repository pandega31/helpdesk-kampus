@extends('layouts.app')

@section('title', 'Kelola Kategori')

@section('content')
    <h1 class="h3 mb-3">Kelola Kategori</h1>

    <div class="card card-body mb-4">
        <h2 class="h6 mb-3">Tambah Kategori Baru</h2>
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <div class="row g-2 align-items-start">
                <div class="col-md-6">
                    <input type="text" name="nama"
                           class="form-control @error('nama') is-invalid @enderror"
                           value="{{ old('nama') }}" placeholder="Nama kategori, misalnya Fasilitas">
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-plus-lg"></i> Tambah Kategori
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="card">
        <table class="table table-hover mb-0 align-middle">
            <thead>
                <tr>
                    <th style="width: 70px">No</th>
                    <th>Nama Kategori</th>
                    <th style="width: 170px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <td>{{ $categories->firstItem() + $loop->index }}</td>
                        <td>{{ $category->nama }}</td>
                        <td>
                            <a href="{{ route('categories.edit', $category) }}"
                               class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('categories.destroy', $category) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Hapus kategori ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted py-4">Belum ada kategori.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $categories->links() }}
    </div>
@endsection