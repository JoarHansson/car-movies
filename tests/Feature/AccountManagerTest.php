<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;


class AccountManagerTest extends TestCase
{
    use RefreshDatabase;

    public function test_view_account_manager_as_logged_in_user(): void
    {
        $this->followingRedirects();

        $user = User::factory()->create([
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'password' => fake()->password()
        ]);

        $this->actingAs($user)
            ->get('/accountManager')
            ->assertStatus(200)
            ->assertSeeText("Account management");
    }

    public function test_try_to_view_account_manager_as_guest(): void
    {
        $this->followingRedirects();

        $this->assertGuest()
            ->get('/accountManager')
            ->assertStatus(200)
            ->assertSeeText(['Email', 'Password', 'Login']); // (redirect to index.blade.php)

    }
}
