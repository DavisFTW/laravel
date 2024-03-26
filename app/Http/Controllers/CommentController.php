<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function show(Post $post)
    {
        $username = Auth::user()->name; // Assuming you are using the 'name' attribute for the username
        return view('posts.comments', compact('post', 'username'));
    }

    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string',
        ]);
    
        $comment = new Comment();
        $comment->content = $request->input('content');
        $comment->user_id = auth()->id(); // Assuming you're using authentication
        $comment->post_id = $post->id; // Assign post_id based on the current post
        $comment->save();
    
        return redirect()->back()->with('success', 'Comment added successfully!');
    }
}
