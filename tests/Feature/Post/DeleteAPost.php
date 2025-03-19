<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteAPostTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_can_not_delete_post_when_post_not_found(): void
    {
        $user = User::factory()->create();

        Article::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user)
            ->delete('/posts/40000');

        $response->assertNotFound();
    }

    public function test_can_not_delete_post_when_not_authorized(): void
    {
        $user = User::factory()->count(2)->create();

        $article = Article::factory()->create([
            'user_id' => $user[0]->id
        ]);

        $response = $this->actingAs($user[1])
            ->delete('/posts/' . $article->id);
        
        $response->assertForbidden();
    }

    public function test_can_delete_post(): void
    {
        $user = User::factory()->create();

        $article = Article::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user)
            ->delete('/posts/' . $article->id);

        $response->assertRedirect('/');
    }
}
