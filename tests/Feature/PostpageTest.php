<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Articles;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostpageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_show_post_page(): void
    {
        $user = User::factory()->create();
        $articles = Articles::factory()->count(10)->create([
            'author_id' => $user->id
        ]);

        $response = $this->get('/posts');

        $response->assertStatus(200);
        $response->assertViewIs('posts.index');
        $response->assertSee('All Posts');
    }
}
