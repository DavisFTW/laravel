<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index Page</title>
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
            <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-200 text-blue-700 rounded hover:bg-blue-300">Login</a>
            <a href="{{ route('register') }}" class="ml-2 px-4 py-2 bg-green-200 text-green-700 rounded hover:bg-green-300">Register</a>
        @endguest
    </header>
    <main class="p-6">
        <div class="mb-4">
            @guest
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-2" role="alert">
                    <span class="block sm:inline">You must be <a href="{{ route('login') }}" class="text-blue-500 hover:underline">logged in</a> or <a href="{{ route('register') }}" class="text-blue-500 hover:underline">registered</a> to post comments.</span>
                </div>
            @endguest
            <form method="POST" action="{{ route('posts.store') }}">
                @csrf
                <div class="mb-4">
                    <label for="title" class="block text-gray-700">Title:</label>
                    <input type="text" name="title" id="title" class="w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none" placeholder="Enter post title" required>
                </div>
                <div class="mb-4">
                    <label for="content" class="block text-gray-700">Content:</label>
                    <textarea name="content" id="content" class="w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none" rows="4" placeholder="Enter post content" required></textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Categories:</label>
                    <div>
                        <input type="checkbox" id="category1" name="categories[]" value="1">
                        <label for="category1">IT</label>
                    </div>
                    <div>
                        <input type="checkbox" id="category2" name="categories[]" value="2">
                        <label for="category2">Economics</label>
                    </div>
                    <div>
                        <input type="checkbox" id="category3" name="categories[]" value="3">
                        <label for="category3">Politics</label>
                    </div>
                </div>
                @guest
                    <button class="mt-2 px-4 py-2 bg-gray-400 text-white rounded cursor-not-allowed" disabled>Post</button>
                @else
                    <button type="submit" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-500">Post</button>
                @endguest
            </form>
        </div>
        <div class="mb-4">
            <form method="GET" action="{{ route('posts.search') }}">
                @csrf
                <div class="mb-4">
                    <label for="search" class="block text-gray-700">Search:</label>
                    <input type="text" name="query" id="search" class="w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none" placeholder="Enter search query" required>
                </div>
                <button type="submit" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-500">Search</button>
            </form>
        </div>
        <section>
            <!-- Loop through posts here -->
            @foreach ($posts->reverse() as $post)
                <article class="mb-4 p-4 bg-white rounded shadow">
                    <h2 class="text-xl font-bold mb-2">{{ $post->title }}</h2>
                    <p>{{ $post->content }}</p>
                    <div class="text-gray-600 text-sm mt-2">
                        <!-- Display category -->
                        <span>Category: 
                            @foreach ($post->categories as $category)
                                {{ $category->name }}
                            @endforeach
                        </span>
                        <br>
                        <!-- Comments Button -->
                        <a href="{{ route('comments.show', $post) }}" class="text-blue-500 hover:underline">Comments</a>
                        <span>Posted by: {{ $post->user->name }}</span>
                        <span class="mx-2">|</span>
                        <span>Posted at: {{ $post->created_at->format('Y-m-d H:i:s') }}</span>
                        @auth
                            @if ($post->user_id == auth()->id())
                                <span class="mx-2">|</span>
                                <a href="{{ route('posts.edit', $post) }}" class="text-blue-500 hover:underline">Edit</a>
                                <span class="mx-2">|</span>
                                <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline">Delete</button>
                                </form>
                            @endif
                        @endauth
                    </div>
                </article>
            @endforeach
        </section>
    </main>
</body>
</html>
