<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::where('is_admin', true)->first();

        return [
            'name' => $this->faker->unique()->word(),
            'body' => $this->faker->paragraph(),
            'user_id' => $user->id,
        ];
    }
}
