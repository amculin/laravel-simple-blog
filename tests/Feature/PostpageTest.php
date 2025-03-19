<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostpageTest extends TestCase
{
    use RefreshDatabase;

    public function test_post_page_is_displayed(): void
    {
        $user = User::factory()->create();
        Article::factory()->count(10)->create([
            'user_id' => $user->id
        ]);

        $response = $this->get('/posts');

        $response->assertStatus(200);
        $response->assertViewIs('posts.index');
        $response->assertSee('All Posts');
        $response->assertSee('Previous');
        $response->assertSee('Next');
    }

    public function test_pagination_works_on_post_page(): void
    {
        $user = User::factory()->create();
        Article::factory()->count(10)->create([
            'user_id' => $user->id
        ]);

        $response = $this->get('/posts?page=2');

        $response->assertStatus(200);
        $response->assertViewIs('posts.index');
        $response->assertSee('All Posts');
        $response->assertSee('Previous');
        $response->assertSee('Next');

        $response = $this->get('/posts?page=1');

        $response->assertStatus(200);
        $response->assertViewIs('posts.index');
        $response->assertSee('All Posts');
        $response->assertSee('Previous');
        $response->assertSee('Next');
    }
}
