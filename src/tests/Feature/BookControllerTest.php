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

    // Delete a book from the list
    public function test_a_book_can_be_deleted()
    {
        // Disabling exception handling for CSRF token mismatch
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        $book = Book::create([
            'title' => 'Title 2023',
            'author' => 'Some Author',
        ]);

        $response = $this->delete("/books/{$book->id}");
        $this->assertDatabaseMissing('books', ['id' => $book->id]);
        $response->assertStatus(302);
        $response->assertRedirect('/');
        $response->assertSessionHas('message', 'Book deleted successfully!');
    }

    // Change an authors name or title
    public function test_author_name_or_book_title_can_be_changed(){
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
    
        $book = Book::create([
            'title' => 'Title 2023',
            'author' => 'Some Author',
        ]);
    
        $updatedTitle = 'Modified Title 2023';
        $updatedAuthor = 'Modified Author Name';

        $response = $this->post("/books/{$book->id}", [
            '_method' => 'PUT',
            'title' => $updatedTitle,
            'author' => $updatedAuthor,
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/');
        
        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'title' => $updatedTitle,
            'author' => $updatedAuthor,
        ]);
    }
}
