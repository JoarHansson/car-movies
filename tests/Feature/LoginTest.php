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

    public function test_view_login_form(): void
    {
        $response = $this->get('/');
        $response->assertSeeText('Email', 'Password');
        $response->assertStatus(200);
    }

    public function test_login_user(): void
    {
        $user = new User;
        $user->create(['name' => 'TestPerson', 'email' => 'test@test.se', 'password' => Hash::make('1234')]);

        $this->followingRedirects()
            ->post('/login', ['email' => $user->email, 'password' => $user->password])
            ->assertStatus(200)
            ->assertSeeText($user->name);
    }

    public function test_login_user_without_password(): void
    {
        $this->followingRedirects()
            ->post('/login', ['email' =>  'notRegistered@email.com', 'password' => '1234'])
            ->assertStatus(200)
            ->assertSeeText('Something went wrong! Please try again.');
    }
}
