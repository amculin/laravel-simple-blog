<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Article;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Article::factory()
            ->count(7)
            ->for(User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com'
            ]))
            ->create();

        Article::factory()
            ->count(5)
            ->for(User::factory()->create([
                'name' => 'Another Test User',
                'email' => 'another.test@example.com'
            ]))
            ->create();
    }
}
