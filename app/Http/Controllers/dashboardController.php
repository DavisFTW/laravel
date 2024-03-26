<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
class DashboardController extends Controller
{
    public function start()
{
    $user = Auth::user();
    $username = "noAcc";

    if ($user) {
        $username = $user->name; // Assuming 'name' is the column in your users table that stores the user's name
    }

    $posts = Post::all();
    return view('index', ['username' => $username, 'posts' => $posts]);
}

}
