<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence(),
            'code' => (string)$this->faker->unique()->randomNumber(),
            'price' => $this->faker->randomFloat()
        ];
    }
}
