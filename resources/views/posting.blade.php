@extends('layout.main')

@section('content')

<div class="card shadow-sm">
    <div class="card-body">
        <h4 class="card-title mb-4">User Post</h4>
        <div class="table-responsive">

            @foreach($postings as $posting)
                <div class="post-item mb-4 position-relative">

                    <!-- Edit Postingan Button: Pindahkan ke pojok kanan atas dari posting -->
                    <form action="{{ route('edit.post', $posting->id) }}" method="get" enctype="multipart/form-data" style="position: absolute; top: 0; right: 0;">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-sm">Edit Postingan</button>
                    </form>

                    <!-- Post Image -->
                    @if($posting->message_gambar)
                        <div class="post-image mb-2">
                            <img src="{{ asset($posting->message_gambar) }}" alt="Post Image" class="img-fluid" style="max-width: 100%; height: auto;">
                        </div>
                    @endif

                    <!-- Post Text -->
                    <div class="post-text mb-2">
                        <p>{{ $posting->message }}</p>
                    </div>

                    <!-- Post Actions (Like and Unlike Buttons) -->
                    <div class="post-actions d-flex justify-content-between align-items-center mb-2">
                        @php
                            $isLiked = $posting->likes->where('user_id', Auth::id())->count() > 0;
                        @endphp

                        @if($isLiked)
                            <form action="{{ route('delete.like', $posting->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-secondary btn-rounded btn-icon">
                                    <i class="ti-heart text-danger"></i>
                                </button>
                                <span> Unlike</span>
                            </form>
                        @else
                            <form action="{{ route('add.like', $posting->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-outline-secondary btn-rounded btn-icon">
                                    <i class="ti-heart"></i>
                                </button>
                                <span> Like</span>
                            </form>
                        @endif

                        <!-- Delete Post Button di sebelah kanan bawah gambar -->
                        <form action="{{ route('delete.post', $posting->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this post?');">
                                Delete Post
                            </button>
                        </form>
                    </div>

                    <!-- Comments Section -->
                    <div class="comments-section mt-3">
                        @if($posting->komens->isEmpty())
                            <p>No comments yet.</p>
                        @else
                            @foreach($posting->komens as $comment)
                                <div class="comment-item mb-2">
                                    <strong>{{ $comment->create_by }}:</strong>
                                    <p>{{ $comment->komen }}</p>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <!-- Comment Form -->
                    <form action="{{ route('add.komen', $posting->id) }}" method="POST" enctype="multipart/form-data" class="mt-2">
                        @csrf
                        <div class="form-group">
                            <textarea name="komen" class="form-control" placeholder="Add a comment" required></textarea>
                        </div>
                        <div class="form-group">
                            <input type="file" name="komen_gambar" class="form-control-file" accept="image/*">
                        </div>
                        <button type="submit" class="btn btn-outline-warning btn-icon-text">
                            <i class="ti-upload btn-icon-prepend"></i>
                            Upload Komen
                        </button>
                    </form>

                </div>
            @endforeach

        </div>
    </div>
</div>

@endsection
