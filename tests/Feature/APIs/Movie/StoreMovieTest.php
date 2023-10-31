<?php

namespace Tests\Feature\APIs\Movie;

use App\Models\Movie;
use Database\Seeders\MovieSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreMovieTest extends TestCase
{
    /**
     * Store of Movie
     *
     */
    public function testStoreMovieStatus201()
    {
        $movieData = [
            'title' => 'Pengabdi Setan 2 Comunion',
            'description' => 'dalah sebuah film horor Indonesia tahun 2022 yang disutradarai dan ditulis oleh Joko Anwar sebagai sekuel dari film tahun 2017, Pengabdi Setan.',
            'rating' => 7,
            'image' => 'test.png'
        ];

        $this->json('POST', 'api/movies', $movieData, ['Accept' => 'application/json'])
        ->assertStatus(201)
        ->assertJsonStructure([
            'message',
            'data'      => [
                'id',
                'title',
                'description',
                'rating',
                'image',
                'created_at',
                'updated_at',
            ]
        ]);
    }
}
