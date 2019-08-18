<?php

namespace Tests\Feature;

use App\Post;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GuestCannotCreatePostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_cannot_create_a_post()
    {
        $response = $this->post(route('posts.store'), [
            'title' => 'Test Title',
            'body' => 'Test Body',
        ]);

        $response->assertRedirect(route('login'));

        $this->assertEmpty(Post::get());
    }
}
