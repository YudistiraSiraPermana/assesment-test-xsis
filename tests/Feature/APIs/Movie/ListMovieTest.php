<?php

namespace Tests\Feature\APIs\Movie;

use App\Models\Movie;
use Database\Seeders\MovieSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ListMovieTest extends TestCase
{
    /**
     * List of Movie
     *
     */
    public function testListOfMovieStatus200()
    {
        $this->seed(MovieSeeder::class);

        $movieData = Movie::all()->toArray();

        $this->json('GET', 'api/movies', $movieData, ['Accept' => 'application/json'])
            ->assertOk();
    }
}
