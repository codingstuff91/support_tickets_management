<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(8),
            'description' => $this->faker->sentence(40),
            'priority' => 'low',
            'user_id' => 1,
        ];
    }
}
