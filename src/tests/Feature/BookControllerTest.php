<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Book;

class BookControllerTest extends TestCase
{
    use RefreshDatabase;
     
    // List Books
    /** @test */
    public function test_books_can_be_viewed(){
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /** @test */
    public function test_books_shows_correct_info(){
        $books = factory(Book::class, 5)->create();
        $response = $this->get('/');

        // checking book titles
        foreach ($books as $book) {
            $response->assertSee($book->title);
        }
    }

    // Add a book to the list
    /** @test */
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
    /** @test */
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
    /** @test */
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

    // Sort by title or author
    /** @test */
    public function test_books_can_be_sorted_by_title_or_author() {
        factory(Book::class)->create(['title' => 'Book C', 'author' => 'Author C']);
        factory(Book::class)->create(['title' => 'Book A', 'author' => 'Author A']);
        factory(Book::class)->create(['title' => 'Book E', 'author' => 'Author E']);
        factory(Book::class)->create(['title' => 'Book B', 'author' => 'Author B']);
        factory(Book::class)->create(['title' => 'Book D', 'author' => 'Author D']);

        // example_case1: sort for book titles in ascending order
        $response_when_title = $this->get('/?column=title&direction=asc');
        $response_when_title->assertStatus(200);
        $response_when_title->assertSeeInOrder([
            'Book A',
            'Book B',
            'Book C',
            'Book D',
            'Book E',
        ]);

        // example_case2: sort for authors in descending order
        $response_when_author = $this->get('/?column=author&direction=desc');
        $response_when_author->assertStatus(200);
        $response_when_author->assertSeeInOrder([
            'Author E',
            'Author D',
            'Author C',
            'Author B',
            'Author A',
        ]);
    }

    // Search for a book by title or author
    /** @test */
    public function test_books_can_be_searched_by_title_or_author(){
        $books = factory(Book::class, 5)->create();

        // search by title
        $searchKeyword_title = $books->first()->title;
        $response_search_title = $this->get('/?search='.$searchKeyword_title);
        $response_search_title->assertSee($searchKeyword_title);

        // search by author
        $searchKeyword_author = $books->last()->author;
        $response_search_author = $this->get('/?search='.$searchKeyword_author);
        $response_search_author->assertSee($searchKeyword_author);
    }
}
