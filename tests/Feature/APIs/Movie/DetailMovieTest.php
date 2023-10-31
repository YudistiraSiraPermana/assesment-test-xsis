<?php

namespace Tests\Feature\APIs\Movie;

use App\Models\Movie;
use Database\Seeders\MovieSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DetailMovieTest extends TestCase
{
    /**
     * Detail of Movie
     *
     */
    public function testDetailOfMovieStatus200()
    {
        $this->seed(MovieSeeder::class);

        $movieData = Movie::all()->toArray();

        $this->json('GET', 'api/movies/1', $movieData, ['Accept' => 'application/json'])
            ->assertOk();
    }
}
