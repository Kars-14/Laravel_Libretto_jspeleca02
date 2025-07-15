@extends('layouts.app')

@section('title', 'Edit Book - Libretto')

@section('content')
@php
    $breadcrumb = 'Books / Edit';
@endphp

<div class="bg-white rounded-lg shadow">
    <div class="px-6 py-4 border-b border-gray-200">
        <h1 class="text-2xl font-semibold text-gray-900">Edit Book: {{ $book->title }}</h1>
    </div>
    
    <div class="p-6">
        <form method="POST" action="{{ route('books.update', $book) }}" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Book Title</label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       value="{{ old('title', $book->title) }}"
                       required
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="author_id" class="block text-sm font-medium text-gray-700">Author</label>
                <select id="author_id" 
                        name="author_id" 
                        required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Select an author</option>
                    @foreach($authors as $author)
                        <option value="{{ $author->id }}" {{ old('author_id', $book->author_id) == $author->id ? 'selected' : '' }}>
                            {{ $author->name }}
                        </option>
                    @endforeach
                </select>
                @error('author_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description (Optional)</label>
                <textarea id="description" 
                          name="description" 
                          rows="4"
                          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('description', $book->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="publication_year" class="block text-sm font-medium text-gray-700">Publication Year (Optional)</label>
                <input type="number" 
                       id="publication_year" 
                       name="publication_year" 
                       value="{{ old('publication_year', $book->publication_year) }}"
                       min="1000"
                       max="2030"
                       placeholder="2024"
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                @error('publication_year')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="isbn" class="block text-sm font-medium text-gray-700">ISBN (Optional)</label>
                <input type="text" 
                       id="isbn" 
                       name="isbn" 
                       value="{{ old('isbn', $book->isbn) }}"
                       placeholder="978-0-123456-78-9"
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                @error('isbn')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="genres" class="block text-sm font-medium text-gray-700">Genres (Optional)</label>
                <div class="mt-2 grid grid-cols-2 md:grid-cols-3 gap-2">
                    @foreach($genres as $genre)
                        <label class="inline-flex items-center">
                            <input type="checkbox" 
                                   name="genres[]" 
                                   value="{{ $genre->id }}"
                                   {{ in_array($genre->id, old('genres', $book->genres->pluck('id')->toArray())) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">{{ $genre->name }}</span>
                        </label>
                    @endforeach
                </div>
                @error('genres')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('books.index') }}" 
                   class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                    Cancel
                </a>
                <button type="submit" 
                        class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Update Book
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
