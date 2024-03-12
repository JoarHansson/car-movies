<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Like;
use Database\Factories\LikeFactory;


class DeleteLikeTest extends TestCase
{
    use RefreshDatabase;

    public function test_delete_like_successfully(): void
    {
        $this->followingRedirects();

        $user = User::factory()->create([
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'password' => fake()->password()
        ]);

        $like = LikeFactory::new()->create([
            'movie_id' => fake()->numberBetween(100000, 999999),
            'movie_title' => fake()->name(),
            'movie_poster' => "/" . fake()->shuffle("1234567890acbdefghijklmnopq") . ".jpg",
            'movie_rating' => fake()->randomFloat(1, 0, 10),
            'user_id' => fake()->randomElement(User::pluck('id')),
        ]);

        $this->actingAs($user)
            ->delete("/deleteLike/{$like->id}")
            ->assertStatus(200);

        $this->assertDatabaseMissing(
            'likes',
            [
                'id' => $like->id,
            ]
        );
    }
}
