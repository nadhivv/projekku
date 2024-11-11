@extends('layout.main')

@section('content')

<div class="row mb-5">
    <div class="col">
        <h3 class="font-weight-bold">Edit Jenis User</h3>
        <h6 class="font-weight-normal mb-0">
            Update user role details as necessary.
        </h6>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <h4 class="card-title mb-4">Update Jenis User</h4>
        <form id="updateRoleForm" method="POST" action="{{ route('update.role', $jenisusers->id) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="jenis_user" class="form-label">Nama Jenis User</label>
                <input type="text" class="form-control" id="jenis_user" name="jenis_user"
                       value="{{ old('jenis_user', $jenisusers->jenis_user) }}" required>
            </div>

            <div class="form-group mt-3">
                <label for="menu_ids" class="form-label">Assign Menus</label>
                <div class="checkbox-list">
                    @foreach ($menus as $menu)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="menu_ids[]" value="{{ $menu->id }}"
                                id="menu_{{ $menu->id }}"
                                {{ in_array($menu->id, $selectedMenusRole) ? 'checked' : '' }}> 
                            <label class="form-check-label" for="menu_{{ $menu->id }}">
                                {{ $menu->menu_name }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-success">Update Jenis User</button>
            </div>
        </form>

        <div class="mt-3">
            <a href="/admin/role" class="btn btn-secondary">Back</a>
        </div>
    </div>
</div>
<br>
<div id="message"></div> <!-- You can show messages here after form submission -->

@endsection
