<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::first()->id,
            'ticket_id' => Ticket::first()->id,
            'body' => $this->faker->sentence(2),
        ];
    }
}
