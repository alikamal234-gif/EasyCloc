<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Flatshare;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Expense>
 */
class ExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->title(),
            'amount' => fake()->randomNumber(),
            'date' => fake()->dateTime(),
            'flatshare_id' => fake()->numberBetween(1,50),
            'category_id' => fake()->numberBetween(1,50),
            'user_id' => fake()->numberBetween(1,50),
        ];
    }
}
