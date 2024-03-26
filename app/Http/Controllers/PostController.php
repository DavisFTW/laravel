<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;

class PostController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        $post = new Post();
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->user_id = auth()->id();
        $post->save();

        if ($request->has('categories')) {
            $post->categories()->sync($request->input('categories'));
        }

        return redirect()->back()->with('success', 'Post created successfully!');
    }

    public function edit(Post $post)
    {
        $username = auth()->user()->name;
        return view('posts.edit', compact('post', 'username'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        $post->update([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
        ]);

        if ($request->has('categories')) {
            $post->categories()->sync($request->input('categories'));
        } else {
            $post->categories()->detach(); 
        }

        return redirect()->route('home')->with('success', 'Post updated successfully!');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('home')->with('success', 'Post deleted successfully!');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $posts = Post::where('title', 'like', '%'.$query.'%')
                        ->orWhere('content', 'like', '%'.$query.'%')
                        ->get();
    
        $username = auth()->user()->name;
    
        return view('posts.search', compact('posts', 'query', 'username'));
    }

    public function storeComment(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $comment = new Comment();
        $comment->content = $request->input('content');
        $comment->user_id = auth()->id(); 
        $comment->post_id = $post->id;
        $comment->save();

        return redirect()->back()->with('success', 'Comment added successfully!');
    }
}
