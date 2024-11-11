@extends('layout.main')

@section('content')
    <h2>List Kategori</h2>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Add New Kategori</h4>
            <form method="POST" action="{{ route('store.kategori') }}">
                @csrf
                <div class="form-group">
                    <label for="categoryName">Kategori</label>
                    <input type="text" class="form-control" id="categoryName" placeholder="Kategori" name="nama_kategori" required>
                </div>
                <button type="submit" class="btn btn-primary mr-2">Submit</button>
            </form>
        </div>
    </div>

    <br>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Table Kategori</h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kategori</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kategoris as $index => $kategori)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $kategori->nama_kategori }}</td>
                            <td>{{ $kategori->created_at->format('D M Y') }}</td>
                            <td>
                                <a href="{{ route('edit.kategori', $kategori->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('delete.kategori', $kategori->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif
@endsection

