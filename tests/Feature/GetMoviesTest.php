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

        $response = $this->actingAs($user)
            ->get('getMovies')
            ->assertStatus(200)
            ->assertSeeText(["Hello {$user->name}"])
            ->assertViewHas('movieList');

            //make sure results are visible
            $viewData = $response->original->getData();
            $this->assertTrue(property_exists($viewData['movieList']->results[0], 'title'));
    }
}
