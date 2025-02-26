<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Compte>
 */
class CompteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "user_id"=> $this->faker->numberBetween(0,10),
            "manager"=> null,
            "collaborateurs "=>["0" => 1],
            "service_id"=> $this->faker->numberBetween(1,10),
        ];
    }
}
