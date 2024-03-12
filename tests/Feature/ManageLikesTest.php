<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\User;
use App\Models\Like;
use Database\Factories\LikeFactory;
use Illuminate\Support\Facades\Http;


class ManageLikesTest extends TestCase
{
    use RefreshDatabase;

        public function test_add_a_like()
        {
            // Ensure there's a user
            $user = User::factory()->create();

            // Define a movie ID
            $movieId = fake()->numberBetween(100000, 999999);

            // Define a page and keywords array
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
                            "id" => $movieId,
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
            ->get('manageLike?movieId='.$movieId.'&page='.$page.'&keyword='.fake()->randomElement($keywords))
            ->assertStatus(302);

            //make sure the movie is added to the database
     $this->assertTrue(
        Like::where('user_id', $user->id)
            ->where('movie_id', $movieId)
            ->exists()
    );
}
    // delete movie from database
    public function test_delete_a_like(): void
    {
        // Define a page and keywords array
        $keywords = [
            '830-car-race', // car race
            '233981', // f1
            '10039-racing', // racing
            '1749', //taxi driver
        ];

        // get random page number
        $page = rand(1, 4);

        //create user
        $user = User::factory()->create([
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'password' => Hash::make('1234')
        ]);
        //create like
        $like = LikeFactory::new()->create([
            'movie_id' => fake()->numberBetween(100000, 999999),
            'movie_title' => fake()->name(),
            'movie_poster' => "/" . fake()->shuffle("1234567890acbdefghijklmnopq") . ".jpg",
            'movie_rating' => fake()->randomFloat(1, 0, 10),
            'user_id' => fake()->randomElement(User::pluck('id')),
        ]);
        //make mock request
        $this->actingAs($user)->get("manageLike", [
            'page' => $page,
            'keyword' => fake()->randomElement($keywords),
            'movieid' => $like->id
        ]);
        // make sure the movie is deleted from the database
        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'movie_id' => $like->id,
        ]);
    }
}
