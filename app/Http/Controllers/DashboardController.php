<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Income;
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
        $incomes = Income::where('user_id', $userId)->get();
        $categories = Category::all();
        $budgetRecord = Budget::where('user_id', $userId)->first();
        $budget = $budgetRecord ? $budgetRecord : (object)['amount' => 0, 'period' => 'monthly'];

        $categoryData = [];
        foreach ($categories as $category) {
            $categoryExpenses = $expenses->where('category_id', $category->id)->sum('amount');
            $categoryData[$category->name] = $categoryExpenses;
        }

        $totalIncome = $incomes->sum('amount');

        return view('dashboard', compact('categoryData', 'budget', 'expenses', 'totalIncome'));
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

        $incomes = Income::where('user_id', $userId)
            ->whereBetween('date', [$startOfYear, $endOfYear])
            ->get();

        $budgetRecord = Budget::where('user_id', $userId)->where('period', 'yearly')->first();
        $budget = $budgetRecord ? $budgetRecord : (object)['amount' => 0, 'period' => 'yearly'];

        $totalIncome = $incomes->sum('amount');

        return response()->json(['expenses' => $expenses, 'budget' => $budget, 'totalIncome' => $totalIncome]);
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

        $incomes = Income::where('user_id', $userId)
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->get();

        $budgetRecord = Budget::where('user_id', $userId)->where('period', 'monthly')->first();
        $budget = $budgetRecord ? $budgetRecord : (object)['amount' => 0, 'period' => 'monthly'];

        $totalIncome = $incomes->sum('amount');

        return response()->json(['expenses' => $expenses, 'budget' => $budget, 'totalIncome' => $totalIncome]);
    }

    public function getExpensesByPeriod(Request $request)
    {
        $userId = Auth::id();
        $period = $request->query('period');
        $startDate = null;
        $endDate = null;

        switch ($period) {
            case 'last-month':
                $startDate = now()->subMonth()->startOfMonth();
                $endDate = now()->subMonth()->endOfMonth();
                break;
            case 'last-year':
                $startDate = now()->subYear()->startOfYear();
                $endDate = now()->subYear()->endOfYear();
                break;
            case 'this-week':
                $startDate = now()->startOfWeek();
                $endDate = now()->endOfWeek();
                break;
            case 'last-week':
                $startDate = now()->subWeek()->startOfWeek();
                $endDate = now()->subWeek()->endOfWeek();
                break;
            default:
                if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $period)) {
                    $startDate = $period;
                    $endDate = $period;
                } else {
                    $startDate = now()->startOfMonth();
                    $endDate = now()->endOfMonth();
                }
                break;
        }

        $expenses = Expense::with('category')
            ->where('user_id', $userId)
            ->whereBetween('date', [$startDate, $endDate])
            ->get();

        $incomes = Income::where('user_id', $userId)
            ->whereBetween('date', [$startDate, $endDate])
            ->get();

        $budgetRecord = Budget::where('user_id', $userId)->first();
        $budget = $budgetRecord ? $budgetRecord : (object)['amount' => 0, 'period' => 'monthly'];

        $totalIncome = $incomes->sum('amount');

        return response()->json(['expenses' => $expenses, 'budget' => $budget, 'totalIncome' => $totalIncome]);
    }
}
