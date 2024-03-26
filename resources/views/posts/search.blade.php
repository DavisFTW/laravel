<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
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
            <h1 class="text-2xl font-bold mb-4">Search Results</h1>
            @if ($posts->isEmpty())
                <p>No results found for '{{ $query }}'.</p>
            @else
                <p>Displaying search results for '{{ $query }}':</p>
                <section>
                    <!-- Loop through search results here -->
                    @foreach ($posts as $post)
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
            @endif
        </div>
    </main>
</body>
</html>
