<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostService
{
    public function getAllPosts()
    {
        return Post::all();
    }

    public function getPersonalPosts()
    {
        return Post::query()->where('user_id', Auth::id())->get();
    }

    public function storePosts(array $data, array $categories)
    {
        $post = Post::create($data);
        $post->categories()->sync($categories);

        return $post;
    }

    public function getPostsByGame(int $game_id)
    {
        return Post::query()->where('game_id', $game_id)->get();
    }

    public function getPostsByCategory(int $category_id)
    {
        $post =  Post::whereHas('categories', function ($query) use ($category_id) {
            $query->where('category_id', $category_id);
        })->get();

        return $post;
    }
}
