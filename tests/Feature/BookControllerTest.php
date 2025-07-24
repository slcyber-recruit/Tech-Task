<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Genre;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_index_returns_books()
    {
        Book::factory()->count(3)->create();

        $response = $this->getJson('/api/books');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'message',
                     'data' => [['id', 'title', 'author', 'rating']]
                 ]);
    }

    public function test_store_creates_book()
    {
        $payload = [
            'title' => 'Test Book',
            'author' => 'Test Author',
            'rating' => 8,
        ];

        $response = $this->postJson('/api/books', $payload);

        $response->assertStatus(200)
                 ->assertJsonFragment(['title' => 'Test Book']);

        $this->assertDatabaseHas('books', ['title' => 'Test Book']);
    }

    public function test_update_modifies_existing_book()
    {
        $book = Book::factory()->create();
        $payload = [
            'title' => 'Updated Title',
            'author' => 'Updated Author',
            'rating' => 9, 
        ];

        $response = $this->putJson("/api/books/{$book->id}", $payload);

        $response->assertStatus(200)
                ->assertJson([
                    'message' => 'Successfully updated the book.',
                    'data' => [
                        'title' => 'Updated Title',
                        'author' => 'Updated Author',
                        'rating' => 9
                    ]
                ]);

        $this->assertDatabaseHas('books', ['title' => 'Updated Title']);
    }
    public function test_destroy_soft_deletes_book()
    {
        $book = Book::factory()->create();

        $response = $this->deleteJson("/api/books/{$book->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment(['message' => 'Successfully deleted the book.']);

        $this->assertSoftDeleted('books', ['id' => $book->id]);
    }

    public function test_attach_genres_to_book()
    {
        $book = Book::factory()->create();
        $genres = Genre::factory()->count(2)->create();

        $response = $this->postJson("/api/books/{$book->id}/genres", [
            'genre_ids' => $genres->pluck('id')->toArray()
        ]);

        $response->assertStatus(200)
                ->assertJson([
                    'message' => 'Genres linked successfully',
                    'book' => [
                        'genres' => [
                            ['id' => $genres[0]->id],
                            ['id' => $genres[1]->id]
                        ]
                    ]
                ]);

        $this->assertCount(2, $book->fresh()->genres);
    }
}
