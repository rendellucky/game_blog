<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Category;
use App\Models\Game;
use App\Models\Post;
use App\Services\PostServiceFacade;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = PostServiceFacade::getAllPosts();

        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $games = Game::all();
        $categories = Category::all();
        return view('posts.create', compact('games', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $validatedData = $request->validated();

        $validatedData['slug'] = Str::slug($request->input('title'));
        $validatedData['user_id'] = Auth::id();
        //dd($validatedData);
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $validatedData['imageUrl'] = $imagePath;
        }

        PostServiceFacade::storePosts($validatedData, $request->input('categories'));

        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $games = Game::all();
        $categories = Category::all();
        $selectedCategories = $post->categories->pluck('id')->toArray();
        return view('posts.edit', compact('post', 'categories', 'games', 'selectedCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $post->update($request->validated());

        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }

    public function personal()
    {
        $posts = PostServiceFacade::getPersonalPosts();

        return view('posts.personal', compact('posts'));
    }

    public function showPostsByGame(int $game_id)
    {
        $posts = PostServiceFacade::getPostsByGame($game_id);

        return view('posts.index', compact('posts'));
    }

    public function showPostsByCategory(int $category_id)
    {
        $posts = PostServiceFacade::getPostsByCategory($category_id);

        return view('posts.index', compact('posts'));
    }
}
