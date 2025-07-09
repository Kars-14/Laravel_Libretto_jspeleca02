@extends('layouts.app')

@section('title', $author->name . ' - Libretto')

@section('content')
@php
    $breadcrumb = 'Authors / ' . $author->name;
@endphp

<div class="bg-white rounded-lg shadow">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h1 class="text-2xl font-semibold text-gray-900">{{ $author->name }}</h1>
        <div class="space-x-2">
            <a href="{{ route('authors.edit', $author) }}" 
               class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                Edit
            </a>
            <form method="POST" action="{{ route('authors.destroy', $author) }}" 
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
            <!-- Author Details -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Author Details</h3>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Name</dt>
                        <dd class="text-sm text-gray-900">{{ $author->name }}</dd>
                    </div>
                    @if($author->biography)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Biography</dt>
                        <dd class="text-sm text-gray-900">{{ $author->biography }}</dd>
                    </div>
                    @endif
                    @if($author->birth_date)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Birth Date</dt>
                        <dd class="text-sm text-gray-900">{{ $author->birth_date->format('F d, Y') }}</dd>
                    </div>
                    @endif
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Created At</dt>
                        <dd class="text-sm text-gray-900">{{ $author->created_at->format('F d, Y \a\t g:i A') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Updated At</dt>
                        <dd class="text-sm text-gray-900">{{ $author->updated_at->format('F d, Y \a\t g:i A') }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Books by this Author -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Books ({{ $author->books->count() }})</h3>
                @if($author->books->count() > 0)
                    <div class="space-y-3">
                        @foreach($author->books as $book)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <h4 class="font-medium text-gray-900">
                                <a href="{{ route('books.show', $book) }}" class="hover:text-blue-600">
                                    {{ $book->title }}
                                </a>
                            </h4>
                            @if($book->description)
                                <p class="text-sm text-gray-600 mt-1">{{ Str::limit($book->description, 100) }}</p>
                            @endif
                            <div class="flex justify-between items-center mt-2">
                                <span class="text-xs text-gray-500">
                                    Published: {{ $book->publication_date ? $book->publication_date->format('Y') : 'Unknown' }}
                                </span>
                                @if($book->genres->count() > 0)
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($book->genres as $genre)
                                            <span class="text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded">
                                                {{ $genre->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-sm">This author has no books yet.</p>
                @endif
            </div>
        </div>

        <div class="mt-6 pt-6 border-t border-gray-200">
            <a href="{{ route('authors.index') }}" 
               class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                ← Back to Authors
            </a>
        </div>
    </div>
</div>
@endsection
