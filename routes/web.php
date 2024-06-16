<?php

use App\Http\Controllers\BudgetController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('expenses', ExpenseController::class)->except(['index', 'create', 'show']);
    Route::resource('categories', CategoryController::class)->except(['index', 'create', 'show']);
    Route::resource('budgets', BudgetController::class)->except(['index', 'create', 'show']);

    Route::get('expenses/create', [ExpenseController::class, 'create'])->name('expenses.create');
    Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::get('budgets/create', [BudgetController::class, 'create'])->name('budgets.create');
});;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
