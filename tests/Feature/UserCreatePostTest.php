<?php

namespace Tests\Feature;

use App\Post;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserCreatePostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_create_a_post()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post(route('posts.store'), [
            'title' => 'Test Title',
            'body' => 'Test Body',
        ]);

        $post = Post::first();
        $this->assertEquals('Test Title', $post->title);
        $this->assertEquals('Test Body', $post->body);

        $response->assertRedirect(route('posts.show', $post));
        $response = $this->followRedirects($response);
        $response->assertSee('Test Title');
        $response->assertSee('Test Body');
    }
}
