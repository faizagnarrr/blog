<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Post;
use App\Models\Category;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();

        $posts = Post::with(['user', 'category'])
            ->when($request->category, function ($query, $category) {
                $query->where('category_id', $category);
            })
            ->latest()
            ->paginate(6);

        return view('posts.index', compact('posts', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|max:255',
            'body'        => 'required',
            'category_id' => 'nullable|exists:categories,id'
        ]);

        Post::create([
            'title'       => $request->title,
            'slug'        => Str::slug($request->title) . '-' . time(),
            'body'        => $request->body,
            'category_id' => $request->category_id,
            'user_id'     => auth()->id()
        ]);

        return redirect('/')->with('success', 'Artikel berhasil dipublikasikan.');
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        abort_if(auth()->id() !== $post->user_id, 403);

        $categories = Category::all();
        return view('posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        abort_if(auth()->id() !== $post->user_id, 403);

        $request->validate([
            'title'       => 'required|max:255',
            'body'        => 'required',
            'category_id' => 'nullable|exists:categories,id'
        ]);

        $post->update([
            'title'       => $request->title,
            'body'        => $request->body,
            'category_id' => $request->category_id,
        ]);

        return redirect('/')->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Post $post)
    {
        abort_if(auth()->id() !== $post->user_id, 403);

        $post->delete();
        return redirect('/')->with('success', 'Artikel berhasil dihapus.');
    }
}