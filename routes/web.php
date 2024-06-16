<?php

use App\Http\Controllers\BudgetController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/yearly-expenses', [DashboardController::class, 'getYearlyExpenses']);
    Route::get('/dashboard/monthly-expenses', [DashboardController::class, 'getMonthlyExpenses']);
    // Добавляем маршрут для удаления записей о расходах
    Route::delete('/expenses/{id}', [ExpenseController::class, 'destroy'])->name('expenses.destroy');

    // Продолжаем определение остальных маршрутов...
    Route::resource('expenses', ExpenseController::class)->except(['index', 'show']);
    Route::resource('categories', CategoryController::class)->except(['index', 'show']);
    Route::resource('budgets', BudgetController::class)->except(['index', 'show']);

    Route::get('expenses/create', [ExpenseController::class, 'create'])->name('expenses.create');
    Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::get('budgets/create', [BudgetController::class, 'create'])->name('budgets.create');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
