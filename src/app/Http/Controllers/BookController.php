<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use SimpleXMLElement;
use SplTempFileObject;

class BookController extends Controller
{
    // Show all books
    public function index(Request $request) {
        $searchKeyword = $request->input('search');
        $column = $request->input('column', 'created_at');
        $direction = $request->input('direction', 'desc'); 

        return view('books.index',
        [
            'books' => Book::sort($column, $direction)
                        ->filter($searchKeyword)
                        ->paginate(10)
        ]);
    }

    // Show a single book
    public function show(Book $book) {
        return view('books.show', [
            'book' => $book
        ]);
    }

    // Show add form
    public function create() {
        return view('books.create');
    }

    // Store book data
    public function store(Request $request) {
        $formFields = $request->validate([
            'title' => ['required', Rule::unique('books', 'title')],
            'author' => 'required'
        ]);

        Book::create($formFields);
        return redirect('/')->with('message', 'Book added successfully!');
    }

    // Show edit form
    public function edit(Book $book) {
        return view('books.edit', ['book' => $book]);
    }

    // Update book data
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

    // Export books data in CSV and XML
    public function exportBookData(Request $request)
    {
        $hasTitleSelected = $request->has('title');
        $hasAuthorSelected = $request->has('author');
        $format = $request->input('format', 'csv');

        $booksQuery = DB::table('books');

        if ($hasTitleSelected && $hasAuthorSelected) {
            $booksQuery->select('title', 'author')->orderBy('title');
        } elseif ($hasTitleSelected) {
            $booksQuery->select('title')->orderBy('title');
        } elseif ($hasAuthorSelected) {
            $booksQuery->select('author')->groupBy('author')->orderBy('author');
        }
        
        $booksData = $booksQuery->get();

        if ($format === 'csv') {
            return $this->exportToCsv($booksData);
        }else if ($format === 'xml') {
            return $this->exportToXml($booksData);
        } else {
            abort(400, 'Invalid format!');
        }
    }

    // Export books data as CSV
    private function exportToCsv($books)
    {
        $file = new SplTempFileObject();

        // For CSV header
        $file->fputcsv(array_keys((array) $books[0]));

        // Writing data to the CSV file
        foreach ($books as $book) {
            $file->fputcsv((array) $book);
        }

        // Seek to the beginning
        $file->rewind();

        // Set the response headers for download
        $filename = 'yaraku_book_data.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        // Return CSV response
        return response()->stream(function () use ($file) {
            while (!$file->eof()) {
                echo $file->fgets();
            }
        }, 200, $headers);
    }

    // Export books data as XML
    private function exportToXml($data)
    {
        $xml = new SimpleXMLElement('<books/>');
        foreach ($data as $item) {
            $book = $xml->addChild('book');
            if (isset($item->title)) {
                $book->addChild('title', $item->title);
            }
            if (isset($item->author)) {
                $book->addChild('author', $item->author);
            }
        }

        // Set the response headers for download
        $filename = 'yaraku_book_data.xml';
        $headers = [
            'Content-Type' => 'text/xml',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        // Return XML response
        return response($xml->asXML(), 200, $headers);
    }
}
