<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Your Posts') }}
        </h2>
    </x-slot>

    <div class="container mt-4">
        <a href="{{ route('posts.create') }}" class="btn btn-primary btn-lg">Add post</a>
        <h1 class="my-4">Your Blog Posts</h1>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @foreach ($posts as $post)
            <div class="card mb-4">
                <div class="card-header">
                    <h2>{{ $post->title }}</h2>
                    <p>By {{ $post->user->name }} on {{ $post->created_at->format('d M Y') }}</p>
                </div>
                <div class="card-body">
                    @if ($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" class="img-fluid mb-3" alt="{{ $post->title }}">
                    @endif
                    <p>{{ $post->content }}</p>
                </div>
                <div class="card-footer">
                    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this post?');">Delete</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
</x-app-layout>
