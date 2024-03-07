<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;


class CreateAccountTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_account_successfully(): void
    {
        $this->followingRedirects()
            ->post('/createAccount', [
                'name' => 'TestPerson',
                'email' => 'test@person.se',
                'password' => '1234'
            ])
            ->assertStatus(200)
            // Text on dashboard when successfully logged in and redirected:
            ->assertSeeText(['Hello TestPerson', 'Car Movies', 'Logout']);

        $this->assertDatabaseHas(
            'users',
            [
                'name' => 'TestPerson',
                'email' => 'test@person.se',
            ]
        );
    }

    public function test_try_to_create_account_with_non_unique_email(): void
    {
        User::factory()->create([
            'name' => 'TestPerson',
            'email' => 'test@person.se',
            'password' => '1234'
        ]);

        $this->followingRedirects()
            ->post('/createAccount', [
                'name' => 'TestPerson', // allowed
                'email' => 'test@person.se', // Same email as above (already in the db), not allowed
                'password' => '1234' // allowed
            ])
            ->assertStatus(200)
            // Text on login page when redirected back:
            ->assertSeeText('There is already an account with this email address.');
    }
}
