<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Articles;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        Articles::factory(15)->create();

        /* $this->call([
            ArticlesSeeder::class
        ]); */
    }
}
