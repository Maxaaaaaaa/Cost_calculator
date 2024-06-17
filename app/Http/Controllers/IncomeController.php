<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncomeController extends Controller
{
    public function create()
    {
        $categories = Category::getIncomeCategories();
        return view('incomes.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|string|max:255',
            'new_category' => 'nullable|string|max:255',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'description' => 'nullable|string|max:255',
        ]);

        if ($request->category === 'Others' && $request->new_category) {
            $category = Category::firstOrCreate(['name' => $request->new_category, 'type' => Category::TYPE_INCOME]);
        } else {
            $category = Category::firstOrCreate(['name' => $request->category, 'type' => Category::TYPE_INCOME]);
        }

        if (!$category) {
            return redirect()->back()->withErrors(['category' => 'Invalid category selected.']);
        }

        $income = new Income();
        $income->user_id = Auth::id();
        $income->category_id = $category->id;
        $income->amount = $request->amount;
        $income->date = $request->date;
        $income->description = $request->description;
        $income->save();

        return redirect()->route('dashboard')->with('success', 'Income added successfully.');
    }

    public function destroy($id)
    {
        $income = Income::findOrFail($id);

        if ($income->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $income->delete();

        return response()->json(['success' => 'Income deleted successfully.']);
    }
}
