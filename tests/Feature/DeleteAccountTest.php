<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DeleteAccountTest extends TestCase
{
    use RefreshDatabase;

    public function test_delete_account_successfully(): void
    {
        $this->followingRedirects();

        $user = User::factory()->create([
            'name' => 'TestPerson',
            'email' => 'test@test.se',
            'password' => Hash::make('1234')
        ]);

        $this->actingAs($user)
            ->delete('/deleteAccount', ['currentPassword' => '1234'])
            ->assertStatus(200)
            ->assertSeeText(['Account was successfully deleted.']); // successfully redirected to index.blade.php

        $this->assertDatabaseMissing(
            'users',
            [
                'email' => $user->email,
            ]
        );
    }
}
