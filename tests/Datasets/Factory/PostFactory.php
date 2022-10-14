<?php

namespace Chewbathra\Chewby\Tests\Datasets\Factory;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<Chewbathra\Chewby\Tests\Datasets\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $online = fake()->boolean();

        return [
            'title' => fake()->sentence(5),
            'online' => $online,
            'online_from' => fake()->dateTime(),
            'online_until' => fake()->dateTime(),
            'description' => null,
            'editor' => null,
        ];
    }
}
