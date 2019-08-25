<?php

namespace Tests\Feature;

use App\Post;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserDeletePostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_with_permission_can_delete_any_post()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create();

        $user->addPermission('delete-post');

        $response = $this->actingAs($user)->delete(route('posts.destroy', $post));

        $response->assertStatus(200);

        $this->assertEquals(0, Post::count());
    }

    /** @test */
    public function user_without_permission_cannot_delete_any_post()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create();

        $response = $this->actingAs($user)->delete(route('posts.destroy', $post));

        $response->assertStatus(403);

        $this->assertEquals(1, Post::count());
    }
}
