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
    public function a_user_can_edit_their_own_post()
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

    /** @test */
    public function a_user_cannot_edit_a_different_users_post()
    {
        $user = factory(User::class)->create();
        $anotherUsersPost = factory(Post::class)->create([
            'title' => 'A Title',
            'body' => 'A Body',
        ]);

        $response = $this->actingAs($user)->patch(route('posts.update', $anotherUsersPost), [
            'title' => 'New Title',
            'body' => 'New Body',
        ]);

        $anotherUsersPost->refresh();
        $this->assertEquals('A Title', $anotherUsersPost->title);
        $this->assertEquals('A Body', $anotherUsersPost->body);

        $response->assertStatus(403);
    }

    /** @test */
    public function a_user_with_permission_can_edit_a_different_users_post()
    {
        $user = factory(User::class)->create();
        $anotherUsersPost = factory(Post::class)->create([
            'title' => 'A Title',
            'body' => 'A Body',
        ]);

        $user->addPermission('update-post');

        $response = $this->actingAs($user)->patch(route('posts.update', $anotherUsersPost), [
            'title' => 'New Title',
            'body' => 'New Body',
        ]);

        $anotherUsersPost->refresh();
        $this->assertEquals('New Title', $anotherUsersPost->title);
        $this->assertEquals('New Body', $anotherUsersPost->body);

        $response->assertStatus(302);
    }

    /** @test */
    public function admin_can_edit_any_post()
    {
        $admin = factory(User::class)->states('admin')->create();
        $anotherUsersPost = factory(Post::class)->create([
            'title' => 'A Title',
            'body' => 'A Body',
        ]);

        $response = $this->actingAs($admin)->patch(route('posts.update', $anotherUsersPost), [
            'title' => 'New Title',
            'body' => 'New Body',
        ]);

        $anotherUsersPost->refresh();
        $this->assertEquals('New Title', $anotherUsersPost->title);
        $this->assertEquals('New Body', $anotherUsersPost->body);

        $response->assertRedirect(route('posts.show', $anotherUsersPost));
    }
}
