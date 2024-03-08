<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class ChangePasswordTest extends TestCase
{
    use RefreshDatabase;

    public function test_change_password_successfully(): void
    {
        $this->followingRedirects();

        $user = User::factory()->create([
            'name' => 'TestPerson',
            'email' => 'test@test.se',
            'password' => Hash::make('1234')
        ]);

        $this->actingAs($user)
            ->patch('/changePassword', [
                'currentPassword' => '1234',
                'newPassword' => '5678'
            ])
            ->assertStatus(200)
            ->assertSeeText(['Password was changed successfully.']); // successfully redirected to index.blade.php


        // get the same user from the db but with updated password
        $userDataFromDb = DB::table('users')->where('email', $user->email)->first();

        $this->assertTrue(Hash::check('5678', $userDataFromDb->password));

        $this->assertDatabaseMissing(
            'users',
            [
                'email' => $user->email,
                'password' => $user->password // old password
            ]
        );

        $this->assertDatabaseHas(
            'users',
            [
                'email' => $user->email,
                'password' => $userDataFromDb->password // new password
            ]
        );
    }

    public function test_fail_to_change_password(): void
    {
        $this->followingRedirects();

        $user = User::factory()->create([
            'name' => 'TestPerson',
            'email' => 'test@test.se',
            'password' => Hash::make('1234')
        ]);

        $this->actingAs($user)
            ->patch('/changePassword', [
                'currentPassword' => 'WRONG-CURRENT-PASSWORD',
                'newPassword' => '5678'
            ])
            ->assertStatus(200)
            ->assertSeeText(['The current password you entered was incorrect.']); // redirected back with error.


        // assert nothing was changed in the db:
        $this->assertDatabaseHas(
            'users',
            [
                'email' => $user->email,
                'password' => $user->password // old password
            ]
        );
    }
}
