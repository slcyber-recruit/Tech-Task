<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Genre; // Make sure to import the Genre model

class GenreControllerTest extends TestCase
{
    use RefreshDatabase; // This trait migrates the database for each test and rolls it back

    /**
     * Test that a genre can be successfully stored.
     *
     * @return void
     */
    public function test_genre_can_be_stored_successfully()
    {
        $genreData = ['name' => 'Fiction'];

        $response = $this->postJson('/api/genres', $genreData);

        $response->assertStatus(201) // Assert HTTP 201 Created status
                 ->assertJson([
                     'name' => 'Fiction',
                 ]); // Assert the returned JSON contains the genre name

        $this->assertDatabaseHas('genres', [
            'name' => 'Fiction',
        ]); // Assert the genre was saved to the database
    }

    /**
     * Test that storing a genre with missing name fails validation.
     *
     * @return void
     */
    public function test_storing_genre_with_missing_name_fails_validation()
    {
        $genreData = ['name' => '']; // Missing name

        $response = $this->postJson('/api/genres', $genreData);

        $response->assertStatus(422) // Assert HTTP 422 Unprocessable Entity status for validation errors
                 ->assertJsonValidationErrors(['name']); // Assert validation error for 'name' field
    }

    /**
     * Test that storing a genre with a non-string name fails validation.
     *
     * @return void
     */
    public function test_storing_genre_with_non_string_name_fails_validation()
    {
        $genreData = ['name' => 123]; // Non-string name

        $response = $this->postJson('/api/genres', $genreData);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name']);
    }

    /**
     * Test that storing a genre with a duplicate name fails validation.
     *
     * @return void
     */
    public function test_storing_genre_with_duplicate_name_fails_validation()
    {
        // First, create a genre
        Genre::create(['name' => 'Fantasy']);

        // Attempt to create another genre with the same name
        $genreData = ['name' => 'Fantasy'];

        $response = $this->postJson('/api/genres', $genreData);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name']); // Assert validation error for 'name' field (unique rule)
    }
}