<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_logout_user(): void
    {
        $this->followingRedirects();

        $user = User::factory()->create(['name' => 'TestPerson', 'email' => 'test@test.se', 'password' => '1234']);

        $this->actingAs($user)
            ->get('/logout')
            ->assertStatus(200)
            ->assertSeeText(['Email', 'Password', 'Login']); // (index.blade.php)
    }
}
