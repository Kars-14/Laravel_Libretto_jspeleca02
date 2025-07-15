@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-2xl font-bold text-blue-600">{{ $authorsCount }}</div>
            <div class="text-sm text-gray-600">Total Authors</div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-2xl font-bold text-green-600">{{ $booksCount }}</div>
            <div class="text-sm text-gray-600">Total Books</div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-2xl font-bold text-yellow-600">{{ $genresCount }}</div>
            <div class="text-sm text-gray-600">Total Genres</div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-2xl font-bold text-purple-600">{{ $reviewsCount }}</div>
            <div class="text-sm text-gray-600">Total Reviews</div>
        </div>
    </div>

    <!-- Recent Books -->
    <div class="bg-white rounded-lg shadow mb-8">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Recent Books</h3>
        </div>
        <div class="p-6">
            @if($recentBooks->isEmpty())
                <p class="text-gray-500">No books found.</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($recentBooks as $book)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <h4 class="font-semibold text-gray-900">{{ $book->title }}</h4>
                            <p class="text-gray-600 text-sm">{{ $book->author->name ?? 'Unknown Author' }}</p>
                            <p class="text-gray-500 text-xs">Published: {{ $book->publication_year }}</p>
                            <div class="mt-2">
                                @foreach($book->genres as $genre)
                                    <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded mr-1">
                                        {{ $genre->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Quick Actions</h3>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('authors.index') }}" class="bg-blue-50 hover:bg-blue-100 p-4 rounded-lg text-center transition-colors">
                <div class="text-blue-600 font-medium">Manage Authors</div>
                <div class="text-blue-500 text-sm">View and edit authors</div>
            </a>
            <a href="{{ route('books.index') }}" class="bg-green-50 hover:bg-green-100 p-4 rounded-lg text-center transition-colors">
                <div class="text-green-600 font-medium">Manage Books</div>
                <div class="text-green-500 text-sm">View and edit books</div>
            </a>
            <a href="{{ route('genres.index') }}" class="bg-yellow-50 hover:bg-yellow-100 p-4 rounded-lg text-center transition-colors">
                <div class="text-yellow-600 font-medium">Manage Genres</div>
                <div class="text-yellow-500 text-sm">View and edit genres</div>
            </a>
            <a href="{{ route('reviews.index') }}" class="bg-purple-50 hover:bg-purple-100 p-4 rounded-lg text-center transition-colors">
                <div class="text-purple-600 font-medium">Manage Reviews</div>
                <div class="text-purple-500 text-sm">View and edit reviews</div>
            </a>
        </div>
    </div>
</div>
@endsection
