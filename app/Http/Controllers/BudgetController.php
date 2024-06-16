<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{
    public function index()
    {
        $budgets = Budget::where('user_id', Auth::id())->get();
        return view('budgets.index', compact('budgets'));
    }

    public function create()
    {
        return view('budgets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'period' => 'required|in:monthly,yearly',
        ]);

        Budget::create([
            'user_id' => Auth::id(),
            'amount' => $request->amount,
            'period' => $request->period,
        ]);

        return redirect()->route('dashboard')->with('success', 'Budget added successfully.');
    }
}
