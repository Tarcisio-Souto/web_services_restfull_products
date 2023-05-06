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
            'fk_category' => 1,
            'name' => $this->faker->unique()->name(),
            'description' => $this->faker->sentence()
        ];
    }
}
