<x-app-layout>


    <div class="container">
        <h1 class="my-4 text-3xl font-bold mb-6">Blog Posts</h1>

        @foreach ($posts as $post)
            <div class="card mb-4">
                @if($post->imageUrl)
                    <img src="{{ asset('storage/' . $post->imageUrl) }}" class="card-img-top" alt="{{ $post->title }}">
                @endif
                <div class="card-header">
                    <h2 class="text-2xl font-bold">{{ $post->title }}</h2>
                    <p>By {{ $post->user->name }} on {{ $post->created_at->format('d M Y') }}</p>
                    <p>Game: {{ $post->game->title }} </p>
                    <p>Categories:
                        @foreach ($post->categories as $category)
                            <span class="badge badge-secondary">{{ $category->name }}</span>
                        @endforeach
                    </p>
                </div>
                <div class="card-body">
                    <p>{{ $post->content }}</p>
                </div>
                @auth
                    <div class="card-footer">
                        <span class="likesCount">{{ $post->likes->count() }} Likes</span>
                        <form action="{{ route('like.store') }}" class="likesForm" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <button type="submit" class="btn btn-primary btn-sm">Like</button>
                        </form>
                    </div>
                @endauth
                <div class="card-body">
                    <h3>Comments</h3>
                    <div id="comments">
                        @foreach ($post->comments as $comment)
                            <div class="mb-2">
                                <strong>{{ $comment->user->name }}</strong>:
                                <p>{{ $comment->content }}</p>
                            </div>
                        @endforeach
                    </div>
                    @auth
                        <form action="{{ route('comment.store') }}" class="commentsForm" method="POST">
                            @csrf
                            <div class="form-group">
                                <textarea name="content" class="form-control" rows="3" placeholder="Add a comment"
                                          required></textarea>
                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                            </div>
                            <button type="submit" class="btn btn-primary mt-2">Add comment</button>
                        </form>
                    @endauth
                </div>
            </div>
        @endforeach
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        document.querySelectorAll('.likesForm').forEach(form => {
            form.addEventListener('submit', function (event) {
                event.preventDefault();

                let post_id = this.querySelector('input[name="post_id"]').value;
                let csrfToken = document.querySelector('meta[name="csrf-token"]').content;

                fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        post_id: post_id
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        let likesCountElement = this.closest('.card-footer').querySelector('.likesCount');
                        let likesCount = parseInt(likesCountElement.textContent);
                        likesCountElement.textContent = `${likesCount + 1} Likes`;
                        console.log('Success:', data);
                    })
                    .catch(error => console.error('Error:', error));
            });
        });

        document.querySelectorAll('.commentsForm').forEach(form => {
            form.addEventListener('submit', function (event) {
                event.preventDefault();

                let post_id = this.querySelector('input[name="post_id"]').value;
                let user_id = this.querySelector('input[name="user_id"]').value;
                let content = this.querySelector('textarea[name="content"]').value;
                let csrfToken = document.querySelector('meta[name="csrf-token"]').content;

                fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        post_id: post_id,
                        user_id: user_id,
                        body: content
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.comment) {
                            let commentDiv = document.createElement('div');
                            commentDiv.classList.add('mb-2');
                            commentDiv.innerHTML = `<strong>${data.comment.user.name}</strong>:<p>${data.comment.content}</p>`;
                            this.closest('.card-body').querySelector('#comments').appendChild(commentDiv);
                            this.querySelector('textarea[name="content"]').value = '';
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
    </script>
</x-app-layout>
