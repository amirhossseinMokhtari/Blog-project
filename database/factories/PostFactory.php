<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'user_id' => $this->faker->numberBetween(1, 100),
            'title' => $this->faker->sentence(),
            'body' => $this->faker->paragraphs(2, true),
            'study_time_in_min' => $this->faker->numberBetween(1, 10),
        ];
    }
}
