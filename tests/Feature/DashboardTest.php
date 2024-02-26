<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_view_dashboard_as_logged_in_user(): void
    {
        $this->followingRedirects();

        $user = User::factory()->create(['name' => 'TestPerson', 'email' => 'test@test.se', 'password' => '1234']);

        $this->actingAs($user)
            ->get('/dashboard')
            ->assertStatus(200)
            ->assertSeeText(["Hello {$user->name}"]);
    }

    public function test_view_dashboard_as_guest(): void
    {
        $this->followingRedirects();

        $user = User::factory()->create(['name' => 'TestPerson', 'email' => 'test@test.se', 'password' => '1234']);

        $this->assertGuest()
            ->get('/dashboard')
            ->assertStatus(200)
            ->assertSeeText(['Email', 'Password', 'Login']); // (redirect to index.blade.php)

    }
}
