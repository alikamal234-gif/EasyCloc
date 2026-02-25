<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'amount' => fake()->randomNumber(),
            'paid_at' => fake()->dateTime(),
            'debtor_id' => fake()->numberBetween(1,50),
            'creditor_id' => fake()->numberBetween(1,50),
            'flatshare_id' => fake()->numberBetween(1,50),
        ];
    }
}
