<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserPermissionTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $user = factory(User::class)->create();
        //$user->addPermission('menke');

        $response = $this->get('/menke');

        $response->assertStatus(403);
    }

    /** @test */
    public function fatboy_is_cooler_than_menke()
    {
        $user = factory(User::class)->create();
        $user->addPermission('menke');

        $response = $this->actingAs($user)->get('/menke');

        $response->assertStatus(200);
    }
}
