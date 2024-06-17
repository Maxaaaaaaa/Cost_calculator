<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function create()
    {
        $categories = Category::getExpenseCategories();
        return view('expenses.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'description' => 'nullable|string|max:255',
        ]);

        $category = Category::firstOrCreate(['name' => $request->category, 'type' => Category::TYPE_EXPENSE]);

        $expense = new Expense();
        $expense->user_id = Auth::id();
        $expense->category_id = $category->id;
        $expense->amount = $request->amount;
        $expense->date = $request->date;
        $expense->description = $request->description;
        $expense->save();

        return redirect()->route('dashboard')->with('success', 'Expense added successfully.');
    }

    public function destroy($id)
    {
        $expense = Expense::findOrFail($id);

        if ($expense->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $expense->delete();

        return response()->json(['success' => 'Expense deleted successfully.']);
    }
}
