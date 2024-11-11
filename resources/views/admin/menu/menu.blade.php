@extends('layout.main')

@section('content')
<div class="row mb-4">
    <div class="col">
        <h3 class="font-weight-bold">List User</h3>
        <h6 class="font-weight-normal mb-0">
            All systems are running smoothly! You have <span class="text-primary">3 unread alerts!</span>
        </h6>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <h4 class="card-title mb-4">User List</h4>
        <div class="table-responsive">
            <table class="table table-hover table-striped w-100">
                <table id="myTable" class="table table-hover table-striped w-100">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nama Menu</th>
                        <th>Link Menu</th>
                        <th>Icon Menu</th>
                        <th>Id Parent</th>
                        <th>Create by</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($menus as $menus)
                        <tr>
                            <td>{{ $menus->id }}</td>
                            <td>{{ $menus->menu_name }}</td>
                            <td>{{ $menus->menu_link }}</td>
                            <td>{{ $menus->menu_icon }}</td>
                            <td>{{ $menus->parent_id }}</td>
                            <td>{{ $menus->create_by }}</td>
                            <td>
                                <a href="{{ route('edit.menu', $menus->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('delete.menu', $menus->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
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
        <h4 class="card-title mb-4">Add New Menu</h4>
        <form action="{{ route('store.menu') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="menu_name">Nama Menu</label>
                <input type="text" class="form-control" id="menu_name" name="menu_name" placeholder="Masukkan nama menu" required>
            </div>
            <div class="form-group">
                <label for="menu_link">Link Menu</label>
                <input type="text" class="form-control" id="menu_link" name="menu_link" placeholder="Masukkan link menu" required>
            </div>
            <div class="form-group">
                <label for="menu_icon">Icon Menu</label>
                <input type="menu_icon" class="form-control" id="menu_icon" name="menu_icon" placeholder="Masukkan icon menu" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Menu</button>
        </form>
    </div>
</div>
@endsection

