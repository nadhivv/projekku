@extends('layout.main')

@section('content')

    <div class="row mb-4">
        <div class="col">
            <h3 class="font-weight-bold">List Jenis Users</h3>
            <h6 class="font-weight-normal mb-0">
                Here you can see all user roles!
            </h6>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="card-title mb-4">Jenis User List</h4>
            <div class="table-responsive">
                <table class="table table-hover table-striped w-100">
                    <table class="table table-hover table-striped w-100">
                        <table id="myTable" class="table table-hover table-striped w-100">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Nama Jenis</th>
                                <th>Created By</th>
                                <th>Updated By</th>
                                <th>Assigned Menus</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jenisusers as $jenis)
                                <tr>
                                    <td>{{ $jenis->id }}</td>
                                    <td>{{ $jenis->jenis_user }}</td>
                                    <td>{{ $jenis->create_by }}</td>
                                    <td>{{ $jenis->update_by }}</td>
                                    <td>
                                        @foreach ($jenis->menus as $menu)
                                            <span class="badge badge-primary">{{ $menu->menu_name }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        <a href="{{ route('edit.role', $jenis->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('delete.role', $jenis->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </table>
            </div>
            @if (session('error'))
            <div class="alert alert-danger mt-3">
                {{ session('error') }}
            </div>
            @endif
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
    <br>
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h4 class="card-title mb-4">Add Jenis User</h4>
            <form action="{{ route('store.role') }}" method="POST">
                @csrf
                <form action="{{ route('store.users') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="jenis_user">Nama User</label>
                        <input type="text" class="form-control" id="jenis_user" name="jenis_user" placeholder="Masukkan jenis user" required>
                    </div>
                <button type="submit" class="btn btn-primary">Add User</button>
            </form>
        </div>
    </div>

@endsection


