<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Category;
use App\Models\Budget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $expenses = Expense::where('user_id', $userId)->get();
        $categories = Category::all();
        $budgetRecord = Budget::where('user_id', $userId)->first();
        $budget = $budgetRecord ? $budgetRecord->amount : 0; // Проверка на наличие бюджета

        $categoryData = [];
        foreach ($categories as $category) {
            $categoryExpenses = $expenses->where('category_id', $category->id)->sum('amount');
            $categoryData[$category->name] = $categoryExpenses;
        }

        return view('dashboard', compact('categoryData', 'budget'));
    }
}
