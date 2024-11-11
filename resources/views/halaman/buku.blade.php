@extends('layout.main')

@section('content')

<div class="card">
    <div class="card-body">
        <h4 class="card-title">Add New Buku</h4>
        <form method="POST" action="{{ route('store.buku') }}">
            @csrf
            <div class="form-group">
                <label for="judul">Judul</label>
                <input type="text" class="form-control" id="judul" name="judul" placeholder="Masukkan judul" required>
            </div>
            <div class="form-group">
                <label for="kode">Kode</label>
                <input type="text" class="form-control" id="kode" name="kode" placeholder="Masukkan kode" required>
            </div>
            <div class="form-group">
                <label for="pengarang">Pengarang</label>
                <input type="text" class="form-control" id="pengarang" name="pengarang" placeholder="Masukkan pengarang" required>
            </div>
            <div class="form-group">
                <label for="categorySelect">Kategori</label>
                <select class="form-control" id="categorySelect" name="id_kategori" required>
                    <option value="" disabled selected>Select a Category</option>
                    @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

    </div>
</div>

<br>

<div class="card">
    <div class="card-body">
        <h4 class="card-title">Tabel Buku</h4>
        <div class="table-responsive">
            <table class="table table-hover">
                <table id="myTable" class="table table-hover table-striped w-100">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Kode</th>
                        <th>Pengarang</th>
                        <th>Kategori</th>
                        <th>Created by</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bukus as $index => $buku)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $buku->judul }}</td>
                        <td>{{ $buku->kode }}</td>
                        <td>{{ $buku->pengarang }}</td>
                        <td>{{ $buku->kategori ? $buku->kategori->nama_kategori : 'N/A' }}</td>
                        <td>{{ $buku->created_by }}</td>
                        <td>
                            <!-- Tombol Edit -->
                            <a href="{{ route('edit.buku', $buku->id) }}" class="btn btn-sm btn-warning" title="Edit Buku">
                                <i class="fas fa-edit"></i> Edit
                            </a>

                            <!-- Tombol Delete -->
                            <form action="{{ route('delete.buku', $buku->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this book?');" title="Delete Buku">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#myTable').DataTable({
            "paging": true,       // Menampilkan pagination
            "searching": true,    // Menampilkan kotak pencarian
            "ordering": true,     // Mengaktifkan pengurutan kolom
            "info": true          // Menampilkan informasi jumlah data
        });
    });
</script>
@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
@endif

@endsection
