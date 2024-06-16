<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    // Метод для отображения формы создания расхода
    public function create()
    {
        $categories = [
            'Food & Drinks', 'Housing', 'Shopping', 'Transport', 'Vehicle', 'Medicine',
            'Education', 'Travels', 'Entertainment', 'Investments', 'Internet', 'Others'
        ];

        return view('expenses.create', compact('categories'));
    }

    // Метод для сохранения нового расхода
    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'description' => 'nullable|string|max:255',
            'new_category' => 'nullable|string|max:255'
        ]);

        $categoryName = $request->category;
        if ($categoryName === 'Others' && $request->filled('new_category')) {
            $categoryName = $request->new_category;
            Category::firstOrCreate(['name' => $categoryName]);
        }

        $category = Category::firstOrCreate(['name' => $categoryName]);

        Expense::create([
            'user_id' => Auth::id(),
            'category_id' => $category->id,
            'amount' => $request->amount,
            'date' => $request->date,
            'description' => $request->description,
        ]);

        return redirect()->route('dashboard')->with('success', 'Расход успешно добавлен.');
    }

    // Метод для удаления расхода
    public function destroy($id)
    {
        $expense = Expense::find($id);
        if ($expense && $expense->user_id === Auth::id()) {
            $expense->delete();
            return response()->noContent(); // Возвращаем пустой ответ с кодом 204
        }

        return response()->json(['error' => 'Expense not found or unauthorized'], 404);
    }
}
