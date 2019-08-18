<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserLoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_login()
    {
        $user = factory(User::class)->create([
            'email' => 'user@example.org',
            'password' => bcrypt('password'),
        ]);

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('home'));
    }

    /** @test */
    public function user_cannot_login_with_invalid_credentials()
    {
        $user = factory(User::class)->create([
            'email' => 'user@example.org',
            'password' => bcrypt('password'),
        ]);

        $response = $this->from(route('login'))
            ->post(route('login'), [
                'email' => $user->email,
                'password' => 'not-their-password',
            ]);

        $response->assertRedirect(route('login'));
    }
}
