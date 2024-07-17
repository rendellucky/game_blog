<?php

namespace App\Services;

use App\Models\Game;
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

    public function storePosts(array $validatedData)
    {
        $validatedData['user_id'] = Auth::id();

        return Post::create($validatedData);
    }

    public function getPostsByGame(int $game_id)
    {
        return Post::query()->where('game_id', $game_id)->get();
    }
}
