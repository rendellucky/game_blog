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

    public function storePosts(array $validatedData)
    {
        return Post::create($validatedData);
    }
}
