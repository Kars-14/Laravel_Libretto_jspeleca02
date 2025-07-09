@extends('layouts.app')

@section('title', $book->title . ' - Libretto')

@section('content')
@php
    $breadcrumb = 'Books / ' . $book->title;
@endphp

<div class="bg-white rounded-lg shadow">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h1 class="text-2xl font-semibold text-gray-900">{{ $book->title }}</h1>
        <div class="space-x-2">
            <a href="{{ route('books.edit', $book) }}" 
               class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                Edit
            </a>
            <form method="POST" action="{{ route('books.destroy', $book) }}" 
                  class="inline" onsubmit="confirmDelete(event)">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">
                    Delete
                </button>
            </form>
        </div>
    </div>
    
    <div class="p-6">
        <div class="grid md:grid-cols-2 gap-6">
            <!-- Book Details -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Book Details</h3>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Title</dt>
                        <dd class="text-sm text-gray-900">{{ $book->title }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Author</dt>
                        <dd class="text-sm text-gray-900">
                            <a href="{{ route('authors.show', $book->author) }}" class="text-blue-600 hover:text-blue-900">
                                {{ $book->author->name }}
                            </a>
                        </dd>
                    </div>
                    @if($book->description)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Description</dt>
                        <dd class="text-sm text-gray-900">{{ $book->description }}</dd>
                    </div>
                    @endif
                    @if($book->publication_date)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Publication Date</dt>
                        <dd class="text-sm text-gray-900">{{ $book->publication_date->format('F d, Y') }}</dd>
                    </div>
                    @endif
                    @if($book->isbn)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">ISBN</dt>
                        <dd class="text-sm text-gray-900">{{ $book->isbn }}</dd>
                    </div>
                    @endif
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Genres</dt>
                        <dd class="text-sm text-gray-900">
                            @if($book->genres->count() > 0)
                                <div class="flex flex-wrap gap-2 mt-1">
                                    @foreach($book->genres as $genre)
                                        <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">
                                            <a href="{{ route('genres.show', $genre) }}" class="hover:text-blue-900">
                                                {{ $genre->name }}
                                            </a>
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-gray-400">No genres assigned</span>
                            @endif
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Created At</dt>
                        <dd class="text-sm text-gray-900">{{ $book->created_at->format('F d, Y \a\t g:i A') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Updated At</dt>
                        <dd class="text-sm text-gray-900">{{ $book->updated_at->format('F d, Y \a\t g:i A') }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Reviews -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Reviews ({{ $book->reviews->count() }})</h3>
                @if($book->reviews->count() > 0)
                    <div class="space-y-4">
                        @foreach($book->reviews as $review)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <h5 class="font-medium text-gray-900">{{ $review->user->name }}</h5>
                                    <div class="flex items-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <span class="text-yellow-400">★</span>
                                            @else
                                                <span class="text-gray-300">★</span>
                                            @endif
                                        @endfor
                                        <span class="ml-2 text-sm text-gray-600">({{ $review->rating }}/5)</span>
                                    </div>
                                </div>
                                <span class="text-sm text-gray-500">{{ $review->created_at->format('M d, Y') }}</span>
                            </div>
                            @if($review->review_text)
                                <p class="text-sm text-gray-700">{{ $review->review_text }}</p>
                            @endif
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-sm">This book has no reviews yet.</p>
                @endif
            </div>
        </div>

        <div class="mt-6 pt-6 border-t border-gray-200">
            <a href="{{ route('books.index') }}" 
               class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                ← Back to Books
            </a>
        </div>
    </div>
</div>
@endsection
