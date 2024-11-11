@extends('layout.main')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <h4 class="card-title mb-4">Create New Post</h4>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Form Upload Gambar dan Post -->
        <form action="{{ route('store.post') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="message">Message</label>
                <textarea name="message" id="message_text" class="form-control" rows="3" placeholder="Enter your message" required></textarea>
            </div>

            <div class="form-group">
                <label for="message_gambar">Upload Image</label>
                <input type="file" name="message_gambar" id="message_gambar" class="form-control-file" required>
            </div>

            <button type="submit" class="btn btn-primary">Create Post</button>
        </form>
    </div>
</div>
@endsection
