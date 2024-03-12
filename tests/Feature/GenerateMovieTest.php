<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Like;

class GenerateMovieTest extends TestCase
{
    use RefreshDatabase;

    //test to check if a like is saved when a movie id is passed through the form
    public function save_like(): void
    {
        $user = new User();
        $user->name = "test";
        $user->email = "test@test.se";
        $user->password = Hash::make("test");
        $user->save();


        $this->followingRedirects()->post("/manageLike", [1]);

        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'movie_id' => 1
        ]);
    }
    // test if movie is deleted if it exists in database
    public function delete_like(): void
    {

        $user = new User();
        $user->name = "test";
        $user->email = "test@test.se";
        $user->password = Hash::make("test");
        $user->save();

        $like = new Like();
        $like->user_id = $user->id;
        $like->movie_id = 1;
        $like->save();

        $this->followingRedirects()->post("/manageLike", [1]);
        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'movie_id' => 1
        ]);
    }

    public function make_an_api_request(): void
    {
        $response = $this->postJson('/getMovies');
        $response->assertStatus(201)->assertJson(['created' => true]);
    }
}
