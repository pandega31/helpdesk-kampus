@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')
    <h1 class="h3 mb-3">Edit Kategori</h1>

    <div class="card card-body" style="max-width: 560px;">
        <form action="{{ route('categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nama" class="form-label">Nama Kategori</label>
                <input type="text" name="nama" id="nama"
                       class="form-control @error('nama') is-invalid @enderror"
                       value="{{ old('nama', $category->nama) }}">
                @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">Batal</a>
        </form>
    </div>
@endsection