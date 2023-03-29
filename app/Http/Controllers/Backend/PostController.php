<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Inertia\Inertia;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Post/PostIndex', [
            "posts" => PostResource::collection(Post::all())
        ]);
    }

    public function create()
    {
        $this->authorize('create', Post::class);
        return Inertia::render('Admin/Post/CreatePost');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Post::class);
        $attr = $request->validate([
            "title" => "required|string|max:255"
        ]);
        Post::create($attr);
        return to_route("posts.index");
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        return Inertia::render('Admin/Post/EditPost', [
            "post" => new PostResource($post)
        ]);
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);
        $attr = $request->validate([
            "title" => "required|string|max:255"
        ]);
        $post->update($attr);
        return to_route("posts.index");
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();
        return to_route("posts.index");
    }
}
