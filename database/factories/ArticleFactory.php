<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->text(60);
        $date = date('Y-m-d H:i:s');

        return [
            'user_id' => rand(1, 10),
            'title' => ucwords($title),
            'content' => fake()->paragraphs(3, true),
            'status' => rand(1, 3),
            'publish_at' => $date,
            'created_at' => $date,
            'updated_at' => $date
        ];
    }
}
