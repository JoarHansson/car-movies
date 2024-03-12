<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Like>
 */
class LikeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'movie_id' => fake()->numberBetween(100000, 999999),
            'movie_title' => fake()->name(),
            'movie_poster' => "/" . fake()->shuffle("1234567890acbdefghijklmnopq") . ".jpg",
            'movie_rating' => fake()->randomFloat(1, 0, 10),
            'user_id' => fake()->randomElement(User::pluck('id')),
        ];
    }
}
