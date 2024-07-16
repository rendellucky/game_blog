<x-app-layout>


    <div class="container">
        <h1 class="my-4">Blog Posts</h1>

        @foreach ($posts as $post)
            <div class="card mb-4">
                @if($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top" alt="{{ $post->title }}">
                @endif
                <div class="card-header">
                    <h2>{{ $post->title }}</h2>
                    <p>By {{ $post->user->name }} on {{ $post->created_at->format('d M Y') }}</p>
                </div>
                <div class="card-body">
                    <p>{{ $post->content }}</p>
                </div>
                <div class="card-footer">
                    <span>{{ $post->likes->count() }} Likes</span>
                    <form action="{{ route('like.store') }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <button type="submit" class="btn btn-primary btn-sm">Like</button>
                    </form>
                </div>
                <div class="card-body">
                    <h3>Comments</h3>
                    @foreach ($post->comments as $comment)
                        <div class="mb-2">
                            <strong>{{ $comment->user->name }}</strong>:
                            <p>{{ $comment->content }}</p>
                        </div>
                    @endforeach

                    <form action="{{ route('comment.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <textarea name="content" class="form-control" rows="3" placeholder="Add a comment" required></textarea>
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        </div>
                        <button type="submit" class="btn btn-primary mt-2">Submit</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
</x-app-layout>
