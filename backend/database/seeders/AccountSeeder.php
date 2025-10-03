<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Account;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 创建一些示例账户
        Account::factory()->count(5)->create();
        
        // 创建特定的账户
        Account::create([
            'name' => '现金',
            'type' => 'cash',
            'balance' => 1000.00,
            'description' => '日常现金账户',
            'is_active' => true,
        ]);
        
        Account::create([
            'name' => '储蓄卡',
            'type' => 'bank',
            'balance' => 5000.00,
            'description' => '主要储蓄账户',
            'is_active' => true,
        ]);
        
        Account::create([
            'name' => '信用卡',
            'type' => 'credit_card',
            'balance' => -2000.00,
            'description' => '日常消费信用卡',
            'is_active' => true,
        ]);
    }
}