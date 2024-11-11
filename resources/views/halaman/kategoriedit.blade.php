@extends('layout.main')

@section('content')

<div class="row mb-5">
    <div class="col">
        <h3 class="font-weight-bold">Edit Kategori</h3>
    </div>
</div>

    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="card-title mb-4">Update Kategori</h4>
            <form id="updateKategoriForm" method="POST" action="{{ route('update.kategori', $kategoris->id) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="nama_kategori" class="form-label">Nama Kategori</label>
                    <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" value="{{ old('nama_kategori', $kategoris->nama_kategori) }}" required>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-success">Update Kategori</button>
                </div>
            </form>

            <div class="mt-3">
                 <a href="/admin/kategori" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
    <br>
    <div id="message"></div>





@endsection
