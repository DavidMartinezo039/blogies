<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear 5 usuarios con 10 posts
        User::factory(5)->create()->each(function ($user) {
            // Crear 10 posts para cada usuario
            $posts = Post::factory(10)->create(['user_id' => $user->id]);

            // No creamos comentarios para el usuario actual
        });

        // No admin
        $juan = User::factory()->create([
            'name' => 'Juan',
            'last_name' => 'Perez',
            'email' => 'juan@example.com',
            'password' => Hash::make('asdfasdf'),
            'is_admin' => false,
        ]);

        // Crear un usuario específico, "David"
        $david = User::factory()->create([
            'name' => 'David',
            'last_name' => 'Martinez',
            'email' => '1234@gmail.com',
            'password' => Hash::make('asdfasdf'),
            'is_admin' => true,
        ]);

        // Crear comentarios para todos los posts de todos los usuarios (con el usuario David como autor)
        Post::all()->each(function ($post) use ($david) {
            // Crear un comentario de David para cada post
            Comment::factory()->create([
                'content' => 'Tu primer comentario',
                'post_id' => $post->id,
                'user_id' => $david->id,
            ]);
        });

        // Crear 10 categorías con "David" como admin
        Category::factory(10)->create();

        /*foreach ($users as $user) {
            $user->posts()->saveMany(
                Post::factory(10)->make()
            );
        }*/
        /*foreach ($users as $user) {
            Post::factory(10)->create([
                'user_id' => $user->id
            ]);
        }*/
    }
}
