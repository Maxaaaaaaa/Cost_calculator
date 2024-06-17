<?php

namespace App\Http\Controllers;

use App\Models\Income;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncomeController extends Controller
{
    public function create()
    {
        return view('incomes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'description' => 'nullable|string|max:255',
        ]);

        $income = new Income();
        $income->user_id = Auth::id();
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
