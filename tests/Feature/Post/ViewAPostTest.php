<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewAPostTest extends TestCase
{
    use RefreshDatabase;

    public function test_detail_post_can_be_accessed(): void
    {
        $user = User::factory()->create();
        $title = 'Test Post Title';
        $content = 'Test Post Content';

        $article = Article::factory()->create([
            'user_id' => $user->id,
            'title' => $title,
            'content' => $content
        ]);

        $response = $this->get('/posts/' . $article->id);

        $response->assertOk();
        $response->assertViewIs('posts.show');
        $response->assertSee('Post Detail');
        $response->assertSee($title);
        $response->assertSee($content);
    }

    public function test_detail_post_return_404_when_not_found(): void
    {
        $user = User::factory()->create();
        $title = 'Test Post Title';
        $content = 'Test Post Content';

        Article::factory()->create([
            'user_id' => $user->id,
            'title' => $title,
            'content' => $content
        ]);

        $response = $this->get('/posts/10000');

        $response->assertNotFound();
    }
}
