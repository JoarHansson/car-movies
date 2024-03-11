<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class LoginTest extends TestCase
{
    use RefreshDatabase;

    // login controller and login test needs work
    public function test_login_user_successfully(): void
    {
        $user = User::factory()->create([
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'password' => Hash::make('1234')
        ]);

        $this->followingRedirects()
            ->post('/login', ['email' => $user->email, 'password' => '1234'])
            ->assertStatus(200)
            ->assertSeeText("Hello {$user->name}");
    }

    public function test_try_to_login_user_without_password(): void
    {
        $user = User::factory()->create([
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'password' => fake()->password()
        ]);

        $this->followingRedirects()
            ->post('/login', ['email' => $user->email, 'password' => ''])
            ->assertStatus(200)
            ->assertSeeText('Something went wrong! Please try again.');
    }

    public function test_try_to_login_with_non_registered_credentials(): void
    {
        $this->followingRedirects()
            ->post('/login', ['email' =>  'notRegistered@email.com', 'password' => '1234'])
            ->assertStatus(200)
            ->assertSeeText('Something went wrong! Please try again.');
    }
}
