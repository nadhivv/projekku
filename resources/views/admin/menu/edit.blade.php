@extends('layout.main')

@section('content')

<div class="row mb-5">
    <div class="col">
        <h3 class="font-weight-bold">Edit Menu</h3>
        <h6 class="font-weight-normal mb-0">
            All systems are running smoothly! You have <span class="text-primary">3 unread alerts!</span>
        </h6>
    </div>
</div>

    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="card-title mb-4">Update Menu</h4>
            <form id="updateUserForm" method="POST" action="{{ route('update.menu', $menus->id) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="menu_name" class="form-label">Nama Menu</label>
                    <input type="text" class="form-control" id="menu_name" name="menu_name" value="{{ old('menu_name', $menus->menu_name) }}" required>
                </div>

                <div class="form-group">
                    <label for="menu_link" class="form-label">Link Menu</label>
                    <input type="text" class="form-control" id="menu_link" name="menu_link" value="{{ old('menu_link', $menus->menu_link) }}" required>
                </div>

                <div class="form-group">
                    <label for="menu_icon" class="form-label">Icon Menu</label>
                    <input type="icon" class="form-control" id="menu_icon" name="menu_icon" value="{{ old('menu_icon', $menus->menu_icon) }}" required>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-success">Update menu</button>
                </div>
            </form>

            <div class="mt-3">
                 <a href="/admin/menu" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
    <br>
    <div id="message"></div>





@endsection
