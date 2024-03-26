<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comments</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-200">
    <header class="p-6 bg-white flex justify-end items-center">
        @auth
            <span class="text-gray-800">Logged in as: <strong class="font-bold">{{ $username }}</strong></span>
            <form method="POST" action="{{ route('logout') }}" class="ml-2">
                @csrf
                <button type="submit" class="px-4 py-2 bg-red-200 text-red-700 rounded hover:bg-red-300">Logout</button>
            </form>
        @endauth
        @guest
            <p class="text-gray-800">Please <a href="{{ route('login') }}" class="text-blue-600">login</a> or <a href="{{ route('register') }}" class="text-green-600">register</a> to add comments.</p>
        @endguest
    </header>
    <main class="p-6">
        <article class="mb-4 p-4 bg-white rounded shadow">
            <h2 class="text-xl font-bold mb-2">{{ $post->title }}</h2>
            <p>{{ $post->content }}</p>
            <div class="text-gray-600 text-sm mt-2">
                <span>Posted by: {{ $post->user->name }}</span>
                <span class="mx-2">|</span>
                <span>Posted at: {{ $post->created_at->format('Y-m-d H:i:s') }}</span>
            </div>
        </article>
        <section>
            <h3 class="text-xl font-bold mb-2">Comments</h3>
            <!-- Display existing comments -->
            @foreach ($post->comments as $comment)
                <div class="mb-4 p-4 bg-white rounded shadow">
                    <p>{{ $comment->content }}</p>
                    <div class="text-gray-600 text-sm mt-2">
                        @php
                            $commentUser = \App\Models\User::find($comment->user_id);
                        @endphp
                        <span>Commented by: {{ $commentUser ? $commentUser->name : 'Unknown User' }}</span>
                        <span class="mx-2">|</span>
                        <span>Commented at: {{ $comment->created_at->format('Y-m-d H:i:s') }}</span>
                    </div>
                </div>
            @endforeach

            <!-- Form to add a new comment -->
            @auth
                <form method="POST" action="{{ route('comments.store', $post) }}">
                    @csrf
                    <label for="new-comment" class="block text-gray-700">New Comment:</label>
                    <textarea name="content" id="new-comment" class="w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none" rows="4"></textarea>
                    <button type="submit" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-500">Add Comment</button>
                </form>
            @else
                <p class="text-gray-800">Please <a href="{{ route('login') }}" class="text-blue-600">login</a> or <a href="{{ route('register') }}" class="text-green-600">register</a> to add a comment.</p>
            @endauth
        </section>
    </main>
</body>
</html>
