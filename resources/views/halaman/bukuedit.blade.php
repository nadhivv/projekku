@extends('layout.main')

@section('content')

<div class="row mb-5">
    <div class="col">
        <h3 class="font-weight-bold">Edit Buku</h3>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <h4 class="card-title mb-4">Update Buku</h4>
        <form id="updateBukuForm" method="POST" action="{{ route('update.buku', $bukus->id) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="id_kategori" class="form-label">Kategori</label>
                <select class="form-control" id="id_kategori" name="id_kategori" required>
                    <option value="" disabled>Select a Category</option>
                    @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ $bukus->id_kategori == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="judul" class="form-label">Judul</label>
                <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul', $bukus->judul) }}" required>
            </div>

            <div class="form-group">
                <label for="kode" class="form-label">Kode</label>
                <input type="text" class="form-control" id="kode" name="kode" value="{{ old('kode', $bukus->kode) }}" required>
            </div>

            <div class="form-group">
                <label for="pengarang" class="form-label">Pengarang</label>
                <input type="text" class="form-control" id="pengarang" name="pengarang" value="{{ old('pengarang', $bukus->pengarang) }}" required>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-success">Update Buku</button>
            </div>
        </form>

        <div class="mt-3">
             <a href="/admin/buku" class="btn btn-secondary">Back</a>
        </div>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success mt-3">
        {{ session('success') }}
    </div>
@endif

@endsection
