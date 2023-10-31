<?php

namespace Tests\Feature\APIs\Movie;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateMovieTest extends TestCase
{
    /**
     * Update of Movie
     *
     */
    public function testUpdateMovieStatus200()
    {
        $movieDataStore = [
            'title' => 'Tes Title 1',
            'description' => 'Test Description 1',
            'rating' => 6,
            'image' => 'testImage1.png'
        ];

        $this->json('POST', 'api/movies', $movieDataStore, ['Accept' => 'application/json'])
        ->assertStatus(201);

        $movieDataUpdate = [
            'title' => 'Pengabdi Setan 2 Comunion',
            'description' => 'dalah sebuah film horor Indonesia tahun 2022 yang disutradarai dan ditulis oleh Joko Anwar sebagai sekuel dari film tahun 2017, Pengabdi Setan.',
            'rating' => 7,
            'image' => 'test.png'
        ];     

        $this->json('PATCH', 'api/movies/1', $movieDataUpdate, ['Accept' => 'application/json'])
        ->assertOk()
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
