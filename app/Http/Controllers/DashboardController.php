<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $expenses = Expense::where('user_id', Auth::id())->get();
        $categories = Category::all();

        $categoryData = [];
        foreach ($categories as $category) {
            $categoryExpenses = $expenses->where('category_id', $category->id)->sum('amount');
            $categoryData[$category->name] = $categoryExpenses;
        }
        logger()->info('Category Data:', $categoryData);

        return view('dashboard', compact('categoryData'));
    }
}
