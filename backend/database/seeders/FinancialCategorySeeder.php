<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FinancialCategory;

class FinancialCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 创建收入分类
        FinancialCategory::create([
            'name' => '工资',
            'type' => 'income',
            'description' => '主要工作收入'
        ]);
        
        FinancialCategory::create([
            'name' => '奖金',
            'type' => 'income',
            'description' => '额外奖金收入'
        ]);
        
        FinancialCategory::create([
            'name' => '投资收益',
            'type' => 'income',
            'description' => '投资回报收入'
        ]);
        
        // 创建支出分类
        FinancialCategory::create([
            'name' => '餐饮',
            'type' => 'expense',
            'description' => '日常餐饮支出'
        ]);
        
        FinancialCategory::create([
            'name' => '交通',
            'type' => 'expense',
            'description' => '交通费用支出'
        ]);
        
        FinancialCategory::create([
            'name' => '购物',
            'type' => 'expense',
            'description' => '购物消费支出'
        ]);
        
        FinancialCategory::create([
            'name' => '娱乐',
            'type' => 'expense',
            'description' => '娱乐活动支出'
        ]);
        
        FinancialCategory::create([
            'name' => '住房',
            'type' => 'expense',
            'description' => '房租或房贷支出'
        ]);
        
        // 创建一些随机分类
        FinancialCategory::factory()->count(5)->create();
    }
}