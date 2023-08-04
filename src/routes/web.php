<?php

use App\Book;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// All Books
Route::get('/', function () {
    return view('books', [
        'heading' => 'World of Books',
        'books' => Book::all()
    ]);
});


// Single Book
Route::get('/books/{id}', function($id){
    return view('book', [
        'book' => Book::find($id)
    ]);
});
