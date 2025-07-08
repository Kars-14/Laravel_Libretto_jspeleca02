<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books - Libretto</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('dashboard') }}" class="text-xl font-bold text-gray-900">Libretto</a>
                    <span class="text-gray-500">/</span>
                    <span class="text-gray-700">Books</span>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h1 class="text-2xl font-semibold text-gray-900">Books</h1>
            </div>
            
            <div class="p-6">
                @if($books->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($books as $book)
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $book->title }}</h3>
                            <p class="text-gray-600 mb-2">
                                <strong>Author:</strong> 
                                {{ $book->author->name ?? 'No author' }}
                            </p>
                            <p class="text-gray-600 mb-2">
                                <strong>Genres:</strong> 
                                {{ $book->genres->pluck('name')->join(', ') ?: 'No genres' }}
                            </p>
                            <p class="text-gray-600 mb-2">
                                <strong>Reviews:</strong> {{ $book->reviews->count() }}
                            </p>
                            <p class="text-sm text-gray-500">
                                Added: {{ $book->created_at->format('M d, Y') }}
                            </p>
                        </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-6">
                        {{ $books->links() }}
                    </div>
                @else
                    <div class="text-center py-8">
                        <p class="text-gray-500">No books found.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
