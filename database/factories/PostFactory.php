<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Post::class;
    public function definition()
    {
        return [
            'title' => implode(' ', $this->faker->words(5)),
            'content' => implode(' ', $this->faker->words(10)),
            'image' => $this->faker->imageUrl(),
            'vote' => $this->faker->numberBetween(0, 100),
        ];
    }
}