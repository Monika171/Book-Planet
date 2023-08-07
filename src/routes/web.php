<?php

use App\Book;
use App\Http\Controllers\BookController;
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
Route::get('/', [BookController::class, 'index']);

// Show Add Form
Route::get('/books/create', [BookController::class, 'create']);

// Store Book Data
Route::post('/books',[BookController::class, 'store']);

// Show Edit Form
Route::get('/books/{book}/edit',[BookController::class, 'edit']);

// Update Book Info
Route::put('/books/{book}',[BookController::class, 'update']);

// Delete a Book
Route::delete('/books/{book}',[BookController::class, 'destroy']);

// Single Book
Route::get('/books/{book}',[BookController::class, 'show']);

// Export Books Data in CSV and XML
Route::get('/export-book-data', [BookController::class, 'exportBookData']);