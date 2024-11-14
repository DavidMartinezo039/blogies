<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
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
        $categories = Category::factory()->count(5)->create();

        // Crear 5 usuarios con 10 posts cada uno
        User::factory(5)->create()->each(function ($user) use ($categories) {
            // Crear 10 posts para cada usuario
            $posts = Post::factory(10)->create([
                'user_id' => $user->id,
                'category_id' => $categories->random()->id, // Asignar una categoría aleatoria
            ]);
        });

        // Crear un usuario específico, "David"
        $david = User::factory()->create([
            'name' => 'David',  // Nombre
            'last_name' => 'Martinez',  // Apellido
            'email' => '1234@gmail.com',  // Correo
            'password' => Hash::make('12345678'),  // Contraseña cifrada
        ]);

        // Crear comentarios para todos los posts de todos los usuarios (con el usuario David como autor)
        Post::all()->each(function ($post) use ($david) {
            // Crear un comentario de David para cada post
            Comment::factory()->create([
                'content' => 'Tu primer comentario',
                'post_id' => $post->id,
                'user_id' => $david->id, // Asignar el comentario al usuario David
            ]);
        });
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
