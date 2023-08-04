<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // Show all Books
    public function index() {
        return view('books.index', [
            'books' => Book::all()
        ]);
    }

    // Show a single book
    public function show(Book $book) {
        return view('books.show', [
            'book' => $book
        ]);
    }

}
