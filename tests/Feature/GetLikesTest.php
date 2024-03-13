<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Like;
use Database\Factories\LikeFactory;

class GetLikesTest extends TestCase
{
    use RefreshDatabase;

    public function test_load_liked_movies_successfully(): void
    {
        $this->followingRedirects();

        $user = User::factory()->create([
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'password' => fake()->password()
        ]);

        $like = LikeFactory::new()->create([
            'movie_id' => fake()->numberBetween(200, 500),
            'movie_title' => fake()->name(),
            'movie_poster' => "/" . fake()->shuffle("1234567890acbdefghijklmnopq") . ".jpg",
            'movie_rating' => fake()->randomFloat(1, 0, 10),
            'user_id' => fake()->randomElement(User::pluck('id')),
        ]);

        $this->actingAs($user)
            ->get('getLikes')
            ->assertStatus(200)
            ->assertSeeText($like->movie_title);
    }

    public function test_load_empty_likes_view_successfully(): void
    {
        $this->followingRedirects();

        $user = User::factory()->create([
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'password' => fake()->password()
        ]);

        $this->actingAs($user)
            ->get('getLikes')
            ->assertStatus(200)
            ->assertSeeText("Nothing here yet!");
    }
}
