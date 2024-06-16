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
        $budget = $budgetRecord ? $budgetRecord : (object)['amount' => 0, 'period' => 'monthly'];

        $categoryData = [];
        foreach ($categories as $category) {
            $categoryExpenses = $expenses->where('category_id', $category->id)->sum('amount');
            $categoryData[$category->name] = $categoryExpenses;
        }

        return view('dashboard', compact('categoryData', 'budget', 'expenses'));
    }

    public function getYearlyExpenses()
    {
        $userId = Auth::id();
        $startOfYear = now()->startOfYear();
        $endOfYear = now()->endOfYear();
        $expenses = Expense::with('category')
            ->where('user_id', $userId)
            ->whereBetween('date', [$startOfYear, $endOfYear])
            ->get();

        $budgetRecord = Budget::where('user_id', $userId)->where('period', 'yearly')->first();
        $budget = $budgetRecord ? $budgetRecord : (object)['amount' => 0, 'period' => 'yearly'];

        return response()->json(['expenses' => $expenses, 'budget' => $budget]);
    }

    public function getMonthlyExpenses()
    {
        $userId = Auth::id();
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();
        $expenses = Expense::with('category')
            ->where('user_id', $userId)
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->get();

        $budgetRecord = Budget::where('user_id', $userId)->where('period', 'monthly')->first();
        $budget = $budgetRecord ? $budgetRecord : (object)['amount' => 0, 'period' => 'monthly'];

        return response()->json(['expenses' => $expenses, 'budget' => $budget]);
    }
}
