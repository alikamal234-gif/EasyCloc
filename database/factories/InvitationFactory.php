<?php

namespace Database\Factories;

use App\Models\Flatshare;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invitation>
 */
class InvitationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email' => fake()->email(),
            'token' => fake()->regexify('[A-Za-z0-9]{40}'),
            'status' => fake()->randomElement(['pending','accepted','refused']),
            'flatshare_id' => fake()->numberBetween(1,50),
        ];
    }
}
