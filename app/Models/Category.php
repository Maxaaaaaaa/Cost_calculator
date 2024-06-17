<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    const TYPE_EXPENSE = 'expense';
    const TYPE_INCOME = 'income';

    protected $fillable = ['name', 'type'];

    public static function getExpenseCategories()
    {
        return self::where('type', self::TYPE_EXPENSE)->pluck('name');
    }

    public static function getIncomeCategories()
    {
        return self::where('type', self::TYPE_INCOME)->pluck('name');
    }
}
