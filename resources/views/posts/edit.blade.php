<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-200">
    <header class="p-6 bg-white flex justify-end items-center">
        @auth
            <span class="text-gray-800">Logged in as: <strong class="font-bold">{{ $username }}</strong></span>
        @endauth
        @guest
            <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-200 text-blue-700 rounded hover:bg-blue-300">Login</a>
            <a href="{{ route('register') }}" class="ml-2 px-4 py-2 bg-green-200 text-green-700 rounded hover:bg-green-300">Register</a>
        @endguest
    </header>
    <main class="p-6">
        <div class="mb-4">
            <form method="POST" action="{{ route('posts.update', $post) }}">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="title" class="block text-gray-700">Title:</label>
                    <input type="text" name="title" id="title" class="w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none" value="{{ $post->title }}" required>
                </div>
                <label for="edit-post" class="block text-gray-700">Edit Post:</label>
                <textarea name="content" id="edit-post" class="w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none" rows="4">{{ $post->content }}</textarea>
                <button type="submit" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-500">Update</button>
            </form>
        </div>
    </main>
</body>
</html>
