<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\FinancialCategory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Budget>
 */
class BudgetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $category = FinancialCategory::inRandomOrder()->first() ?? FinancialCategory::factory()->create();
        
        $startDate = $this->faker->dateTimeThisYear();
        $endDate = clone $startDate;
        $endDate->modify('+1 month');
        
        return [
            'category_id' => $category->id,
            'amount' => $this->faker->randomFloat(2, 100, 1000),
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
            'description' => $this->faker->sentence(),
        ];
    }
}