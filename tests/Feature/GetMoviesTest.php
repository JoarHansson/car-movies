<?php

namespace Tests\Feature;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Http;


class GetMoviesTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_movies(): void
    {
        $this->followingRedirects();

        $user = User::factory()->create([
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'password' => fake()->password()
        ]);

        // keywords used in the request:
        $keywords = [
            '830-car-race', // car race
            '233981', // f1
            '10039-racing', // racing
            '1749', //taxi driver
        ];

        $page = rand(1, 4); // get random page number

        // Mock request
        Http::fake([
            'https://api.themoviedb.org/3/keyword/*' => Http::response([
                'results' => [
                    [
                        "adult" => false,
                        "backdrop_path" => "/caKZWDGmv5iW2U99skHs75MmOmU.jpg",
                        "genre_ids" => [],
                        "id" => 96721,
                        "original_language" => "en",
                        "original_title" => "Rush",
                        "overview" => "In the 1970s, a rivalry propels race car drivers Niki Lauda and James Hunt to fame and glory — until a horrible accident threatens to end it all.",
                        "popularity" => 34.516,
                        "poster_path" => "/5akKFgS7eeXUw9rKTEujryKrH17.jpg",
                        "release_date" => "2013-09-02",
                        "title" => "Rush",
                        "video" => false,
                        "vote_average" => 7.716,
                        "vote_count" => 6793
                    ]
                ],
            ]),
        ]);


        $response = $this->actingAs($user)
            ->get('getMovies', ['page' => $page, 'keyword' => fake()->randomElement($keywords)])
            ->assertStatus(200)
            ->assertSeeText(["Hello {$user->name}", "Rush", "7.716"]);
        // make sure that the movie is visible on the page

        $response->assertViewHas('movieList');
    }
}
