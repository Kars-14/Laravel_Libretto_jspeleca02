<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    
    protected $fillable = ['title', 'description', 'publication_year', 'isbn', 'author_id'];
    
    /**
     * Get the author that wrote the book
     */
    public function author()
    {
        return $this->belongsTo(Author::class);
    }
    
    /**
     * Get the genres associated with the book
     */
    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'book_genre');
    }
    
    /**
     * Get the reviews for the book
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
