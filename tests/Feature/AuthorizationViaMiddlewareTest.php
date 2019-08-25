<?php

namespace Tests\Feature;

use App\Foo;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorizationViaMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function policy_can_be_applied_via_middleware()
    {
        $user = factory(User::class)->create();
        $foo = factory(Foo::class)->create();

        $response = $this->actingAs($user)->get(route('foo', $foo));

        $response->assertStatus(403);
    }

    /** @test */
    public function prove_foo_route_can_be_authorized()
    {
        $admin = factory(User::class)->states('admin')->create();
        $foo = factory(Foo::class)->create();

        $response = $this->actingAs($admin)->get(route('foo', $foo));

        $response->assertStatus(200);
    }
}
