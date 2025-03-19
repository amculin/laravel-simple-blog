<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomepageTest extends TestCase
{
    use RefreshDatabase;

    public function test_show_login_or_register_link_on_homepage_when_unauthenticated(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('home');
        $response->assertSee('Home');
        $response->assertSee('login');
    }

    public function test_show_created_posts_on_homepage_when_authenticated(): void
    {
        $user = User::factory()->create();

        Article::factory()->count(10)->create([
            'user_id' => $user->id,
            'status' => Article::IS_ACTIVE
        ]);

        $response = $this->actingAs($user)
            ->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('home');
        $response->assertSee('Your Posts');
        $response->assertSee('Detail');
        $response->assertSee('Edit');
        $response->assertSee('Delete');
    }

    public function test_pagination_works_on_homepage_when_authenticated(): void
    {
        $user = User::factory()->create();

        Article::factory()->count(10)->create([
            'user_id' => $user->id,
            'status' => Article::IS_ACTIVE
        ]);

        $response = $this->actingAs($user)
            ->get('/?page=2');

        $response->assertStatus(200);
        $response->assertViewIs('home');
        $response->assertSee('Your Posts');
        $response->assertSee('Detail');
        $response->assertSee('Edit');
        $response->assertSee('Delete');
    }
}
