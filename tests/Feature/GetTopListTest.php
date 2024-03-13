<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class GetTopListTest extends TestCase
{
    use RefreshDatabase;

    //Tests if user is redirected to the TopList-view
    public function test_generate_top_list(): void
    {
        $this->followingRedirects();

        //Create user
        $user = User::factory()->create([
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'password' => fake()->password()
        ]);

        //Fake request
        $response = $this->actingAs($user)
            ->get('getToplist');

        //Check response for topList and correct movie in view
        $response->assertStatus(200)
            ->assertViewHas('topList')
            ->assertViewHas('liked')
            ->assertSeeText(["Hello {$user->name}", "Murder Mystery", "6.278"]);
    }
}
