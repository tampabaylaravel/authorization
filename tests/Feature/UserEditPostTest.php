<?php

namespace Tests\Feature;

use App\Post;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserEditPostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_edit_a_post()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->make();

        $user->posts()->save($post);

        $response = $this->actingAs($user)->patch(route('posts.update', $post), [
            'title' => 'New Title',
            'body' => 'New Body',
        ]);

        $post->refresh();
        $this->assertEquals('New Title', $post->title);
        $this->assertEquals('New Body', $post->body);

        $response->assertRedirect(route('posts.show', $post));
    }
}
