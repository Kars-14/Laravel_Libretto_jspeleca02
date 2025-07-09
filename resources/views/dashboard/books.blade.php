@extends('layouts.app')

@section('title', 'Books - Libretto')

@section('content')
@php
    $breadcrumb = 'Books';
@endphp

<div class="bg-white rounded-lg shadow">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h1 class="text-2xl font-semibold text-gray-900">Books</h1>
        <a href="{{ route('books.create') }}" 
           class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
            Add New Book
        </a>
    </div>
    
    <div class="p-6">
        @if($books->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Publication Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Genres</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($books as $book)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $book->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $book->title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <a href="{{ route('authors.show', $book->author) }}" class="text-blue-600 hover:text-blue-900">
                                    {{ $book->author->name }}
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $book->publication_date ? $book->publication_date->format('M d, Y') : 'Unknown' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($book->genres->count() > 0)
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($book->genres->take(2) as $genre)
                                            <span class="text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded">
                                                {{ $genre->name }}
                                            </span>
                                        @endforeach
                                        @if($book->genres->count() > 2)
                                            <span class="text-xs text-gray-500">+{{ $book->genres->count() - 2 }} more</span>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-gray-400">No genres</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <a href="{{ route('books.show', $book) }}" 
                                   class="text-blue-600 hover:text-blue-900">View</a>
                                <a href="{{ route('books.edit', $book) }}" 
                                   class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                <form method="POST" action="{{ route('books.destroy', $book) }}" 
                                      class="inline" onsubmit="confirmDelete(event)">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $books->links() }}
            </div>
        @else
            <div class="text-center py-8">
                <p class="text-gray-500">No books found.</p>
                <a href="{{ route('books.create') }}" 
                   class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                    Add First Book
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
