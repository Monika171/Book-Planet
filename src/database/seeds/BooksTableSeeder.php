<?php

use Illuminate\Database\Seeder;
use App\Book;
use Faker\Factory as Faker;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Book::truncate();
        factory(Book::class, 10)->create();
    }
}
