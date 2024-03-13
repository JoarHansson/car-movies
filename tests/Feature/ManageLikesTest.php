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

    //Add a like and return to discover-view
    public function test_add_a_like_and_return_to_discover()
    {

        $this->followingRedirects();

        // Ensure there's a user
        $user = User::factory()->create([
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'password' => fake()->password()
        ]);

        // Define a movie id
        $movieId = fake()->numberBetween(100000, 999999);

        // Define a page and keywords array
        $keywords = [
            '830-car-race', // car race
            '233981', // f1
            '10039-racing', // racing
            '1749', //taxi driver
        ];

        $page = rand(1, 4); // Get random page number
        $randomNumber = rand(0, 3); // Generate random keyword

        //Fake request
        $response = $this->actingAs($user)
            ->get('manageLike?movieId=' . $movieId . '&page=' . $page . '&keyword=' . $keywords[$randomNumber])
            ->assertStatus(200)
            ->assertViewHas('liked');

        //Make sure the movie is added to the database
        $this->assertTrue(
            Like::where('user_id', $user->id)
                ->where('movie_id', $movieId)
                ->exists()
        );
        $viewData = $response->original->getData();
        $this->assertTrue(property_exists($viewData['movieList']->results[0], 'title'));
    }


    // Delete movie from database
    public function test_delete_a_like(): void
    {
        // Define a page and keywords array
        $keywords = [
            '830-car-race', // car race
            '233981', // f1
            '10039-racing', // racing
            '1749', //taxi driver
        ];

        // Get random page number
        $page = rand(1, 4);

        //Create user
        $user = User::factory()->create([
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'password' => Hash::make('1234')
        ]);
        //Create like
        $like = LikeFactory::new()->create([
            'movie_id' => fake()->numberBetween(100000, 999999),
            'movie_title' => fake()->name(),
            'movie_poster' => "/" . fake()->shuffle("1234567890acbdefghijklmnopq") . ".jpg",
            'movie_rating' => fake()->randomFloat(1, 0, 10),
            'user_id' => fake()->randomElement(User::pluck('id')),
        ]);
        //Make mock request
        $this->actingAs($user)->get("manageLike", [
            'page' => $page,
            'keyword' => fake()->randomElement($keywords),
            'movieid' => $like->id
        ]);
        // Make sure the movie is deleted from the database
        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'movie_id' => $like->id,
        ]);
    }

    //Add a like and return to topList-view
    public function test_add_a_like_and_return_to_toplist()
    {

        $this->followingRedirects();

        // Ensure there's a user
        $user = User::factory()->create([
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'password' => fake()->password()
        ]);

        // Define a movie ID
        $movieId = fake()->numberBetween(100000, 999999);

        //Fake request
        $response = $this->actingAs($user)
            ->get('manageLike?movieId=' . $movieId);

        //Make sure uer is returned to TopList-view
        $response->assertStatus(200)
            ->assertViewHas('topList')
            ->assertViewHas('liked')
            ->assertSeeText(["Hello {$user->name}", "Murder Mystery", "6.278"]);

        //Make sure the movie is added to the database
        $this->assertTrue(
            Like::where('user_id', $user->id)
                ->where('movie_id', $movieId)
                ->exists()
        );
    }
}
