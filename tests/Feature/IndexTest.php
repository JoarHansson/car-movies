<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;


class IndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_view_login_form_if_guest(): void
    {
        $this->assertGuest()
            ->get('/')
            ->assertSeeText('Login', 'Email', 'Password')
            ->assertStatus(200);
    }

    public function test_redirect_to_dashboard_if_logged_in(): void
    {
        $user = User::factory()->create([
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'password' => fake()->password()
        ]);

        $this->followingRedirects();

        $this->actingAs($user)
            ->get('/')
            ->assertSeeText("Hello {$user->name}")
            ->assertStatus(200);
    }
}
