<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Book;

class BookControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */

    // List Books
    public function test_books_can_be_viewed(){
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_books_shows_correct_info(){
        $books = factory(Book::class, 5)->create();
        $response = $this->get('/');

        // checking book titles
        foreach ($books as $book) {
            $response->assertSee($book->title);
        }
    }

    // Add a book to the list
    public function test_new_book_can_be_added() {
        // Disabling CSRF protection for this test
        $this->withoutMiddleware();

        $bookData = [
            'title' => 'Title 2023',
            'author' => 'Author new',
        ];
        $response = $this->post('/books', $bookData);
        $response->assertStatus(302);
        $this->assertCount(1, Book::all());
        $this->assertDatabaseHas('books', $bookData);
    }
}
