<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateNewPostTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_not_access_create_new_post_form_when_unauthenticated(): void
    {
        $response = $this->get('/posts/create');

        $response->assertRedirect('/login');
    }

    public function test_can_access_create_new_post_form_when_authenticated(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get('/posts/create');

        $response->assertOk();
        $response->assertViewIs('posts.create');
        $response->assertSeeInOrder([
            'Create New Post', 'Title', 'Content', 'Publish Date', 'Save as Draft'
        ]);
    }

    public function test_can_create_new_post_with_valid_data(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post('/posts/store', [
                'title' => 'Test Post Title',
                'content' => 'Test Post Content',
                'is_draft' => '0',
                'publish_date' => '29-03-2025'
            ]);
        
        $response->assertValid();
        $response->assertRedirect('/');
    }

    public function test_can_not_create_new_post_with_invalid_data(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post('/posts/store', [
                'title' => '',
                'content' => 'Test Post Content',
                'is_draft' => '0',
                'publish_date' => '29-03-2025'
            ]);
        
        $response->assertInvalid(['title' => 'The title field is required.']);
    }
}
