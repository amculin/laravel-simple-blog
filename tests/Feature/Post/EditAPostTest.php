<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EditAPostTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_not_access_edit_post_form_when_unauthenticated(): void
    {
        $user = User::factory()->create();
        $title = 'Test Post Title';
        $content = 'Test Post Content';

        $article = Article::factory()->create([
            'user_id' => $user->id,
            'title' => $title,
            'content' => $content
        ]);

        $response = $this->get('/posts/edit/' . $article->id);

        $response->assertRedirect('/login');
    }

    public function test_can_not_access_edit_post_form_when_unauthorized(): void
    {
        $user = User::factory()->count(2)->create();

        $article = Article::factory()->create([
            'user_id' => $user[1]->id
        ]);

        $response = $this->actingAs($user[0])
            ->get('/posts/edit/' . $article->id);

        $response->assertForbidden();
    }

    public function test_can_access_edit_post_form_when_authorized(): void
    {
        $user = User::factory()->create();

        $article = Article::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user)
            ->get('/posts/edit/' . $article->id);

        $response->assertOk();
        $response->assertViewIs('posts.edit');
        $response->assertSeeInOrder([
            'Edit Post', 'Title', 'Content', 'Publish Date', 'Save as Draft'
        ]);
        $response->assertViewHas('post');
    }

    public function test_edit_post_return_404_when_not_found(): void
    {
        $user = User::factory()->create();

        Article::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user)
            ->get('/posts/edit/10000');

        $response->assertNotFound();
    }

    public function test_can_not_update_post_with_invalid_data(): void
    {
        $user = User::factory()->create();

        $article = Article::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user)
            ->put('/posts/update/' . $article->id, [
                'title' => 'This Title Will Be Updated with More Than 60 Characters to Check Whether The Error Message Will Be Shown.',
                'content' => ''
            ]);

        $response->assertInvalid([
            'title' => 'The title field must not be greater than 60 characters.',
            'content' => 'The content field is required.',
        ]);
    }

    public function test_can_not_update_post_when_post_not_found(): void
    {
        $user = User::factory()->create();

        Article::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user)
            ->put('/posts/update/40000', [
                'title' => 'Updated Title',
                'content' => 'Updated Content'
            ]);

        $response->assertNotFound();
    }

    public function test_can_not_update_post_when_not_authorized(): void
    {
        $user = User::factory()->count(2)->create();

        $article = Article::factory()->create([
            'user_id' => $user[0]->id
        ]);

        $response = $this->actingAs($user[1])
            ->put('/posts/update/' . $article->id, [
                'title' => 'Updated Title',
                'content' => 'Updated Content'
            ]);
        
        $response->assertForbidden();
    }

    public function test_can_update_post_with_valid_data(): void
    {
        $user = User::factory()->create();

        $article = Article::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user)
            ->put('/posts/update/' . $article->id, [
                'title' => 'Updated Title',
                'content' => 'Updated Content'
            ]);

        $response->assertValid();
        $response->assertRedirect('/');
    }

}
