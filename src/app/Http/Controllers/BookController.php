<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BookController extends Controller
{
    // Show all Books
    public function index() {
        return view('books.index', [
            'books' => Book::latest()->filter(request(['search']))->paginate(10)
        ]);
    }

    // Show a single book
    public function show(Book $book) {
        return view('books.show', [
            'book' => $book
        ]);
    }

    // Show Add Form
    public function create() {
        return view('books.create');
    }

    // Store Book Data
    public function store(Request $request) {
        $formFields = $request->validate([
            'title' => ['required', Rule::unique('books', 'title')],
            'author' => 'required'
        ]);

        Book::create($formFields);

        return redirect('/')->with('message', 'Book added successfully!');
    }

    // Show Edit Form
    public function edit(Book $book) {
        return view('books.edit', ['book' => $book]);
    }

    // Update Book Data
    public function update(Request $request, Book $book) {
        $formFields = $request->validate([
            'title' => 'required',
            'author' => 'required'
        ]);

        $book->update($formFields);

        return redirect('/')->with('message', 'Book info updated successfully!');
    }

    // Delete a Book
    public function destroy(Book $book) {
        $book->delete();
        return redirect('/')->with('message', 'Book deleted successfully!');
    }

}
