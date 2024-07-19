<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Post') }}
        </h2>
    </x-slot>

    <div class="container mt-4">
        <h1 class="my-4">Edit Post</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $post->title) }}"
                       required>
            </div>

            <div class="form-group">
                <label for="content">Content</label>
                <textarea class="form-control" id="content" name="content" rows="5"
                          required>{{ old('content', $post->content) }}</textarea>
            </div>

            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" class="form-control-file" id="image" name="image">
                @if ($post->imageUrl)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $post->imageUrl) }}" alt="{{ $post->title }}" class="img-fluid"
                             width="200">
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="game_id">Game</label>
                <select class="form-control" id="game_id" name="game_id" required>
                    <option value="">Select a game</option>
                    @foreach($games as $game)
                        <option
                            value="{{ $game->id }}"{{ old('game_id', $post->game_id) == $game->id ? 'selected' : '' }}>{{ $game->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="categories">Categories</label>
                <select class="form-control" id="categories" name="categories[]" multiple required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ in_array($category->id, old('categories', $selectedCategories)) ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary mt-2">Update Post</button>
        </form>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
</x-app-layout>
