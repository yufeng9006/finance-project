<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialCategory extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'financial_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'type',
    ];

    /**
     * Get the transactions with this category.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'category_id');
    }

    /**
     * Get the budgets with this category.
     */
    public function budgets()
    {
        return $this->hasMany(Budget::class, 'category_id');
    }
}