<?php

namespace Database\Seeders;

use App\Models\Post;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear 10 usuarios
        User::factory(10)->create()->each(function ($user) {
            // Insertar 10,000 posts de forma optimizada
            $posts = [];
            for ($i = 0; $i < 1000; $i++) {
                $posts[] = [
                    'title' => fake()->sentence,
                    'content' => fake()->paragraph(10),
                    'user_id' => $user->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            Post::insert($posts);
        });
    }
}
