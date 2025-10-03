<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Account;
use App\Models\FinancialCategory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $account = Account::inRandomOrder()->first() ?? Account::factory()->create();
        $category = FinancialCategory::inRandomOrder()->first() ?? FinancialCategory::factory()->create();
        
        return [
            'account_id' => $account->id,
            'category_id' => $category->id,
            'amount' => $this->faker->randomFloat(2, 1, 1000),
            'description' => $this->faker->sentence(),
            'transaction_date' => $this->faker->dateTimeThisYear(),
            'type' => $category->type,
        ];
    }
}