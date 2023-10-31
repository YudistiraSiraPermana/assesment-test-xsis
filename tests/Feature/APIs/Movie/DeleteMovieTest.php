<?php

namespace Tests\Feature\APIs\Movie;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteMovieTest extends TestCase
{
    /**
     * Delete of Movie
     *
     */
    public function testDeleteMovieStatus201()
    {
        $movieDataStore = [
            'title' => 'Tes Title 1',
            'description' => 'Test Description 1',
            'rating' => 6,
            'image' => 'testImage1.png'
        ];

        $this->json('POST', 'api/movies', $movieDataStore, ['Accept' => 'application/json'])
        ->assertStatus(201);

        $this->json('DELETE', 'api/movies/1', ['Accept' => 'application/json'])
        ->assertOk();
    }
}
