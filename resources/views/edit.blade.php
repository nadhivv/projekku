@extends('layout.main')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <h4 class="card-title mb-4">Edit Post</h4>

        <form action="{{ route('update.post', $posting->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-group">
                <label for="message">Post Message</label>
                <textarea name="message" class="form-control" id="message" rows="4" required>{{ old('message', $posting->message) }}</textarea>
            </div>

            @if($posting->message_gambar)
                <div class="form-group">
                    <label for="current_image">Current Image</label>
                    <div class="post-image mb-2">
                        <img src="{{ asset($posting->message_gambar) }}" alt="Current Post Image" class="img-fluid" style="max-width: 100%; height: auto;">
                    </div>
                </div>
            @endif

            <div class="form-group">
                <label for="message_gambar">Change Image (Optional)</label>
                <input type="file" name="message_gambar" class="form-control-file" id="message_gambar" accept="image/*">
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Update Postingan</button>
                <a href="/user/post" class="btn btn-secondary">Back</a>
            </div>
        </form>
    </div>
</div>
@endsection
