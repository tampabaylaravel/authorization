<?php

namespace Tests\Feature;

use App\Foo;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorizeViaMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $user = factory(User::class)->create();
        $foo = factory(Foo::class)->create();

        $response = $this->actingAs($user)->get(route('foo', $foo));

        $response->assertStatus(403);
    }

    public function test_can_200_from_middleware()
    {
        $admin = factory(User::class)->states('admin')->create();
        $foo = factory(Foo::class)->create();

        $response = $this->actingAs($admin)->get(route('foo', $foo));

        $response->assertStatus(200);
    }
}
