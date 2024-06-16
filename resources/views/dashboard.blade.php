<!-- resources/views/dashboard.blade.php -->
@extends('layouts.app')

@section('title', 'Cost Calculator')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Логика калькулятора стоимости -->
                    <form id="cost-calculator-form">
                        <div>
                            <label for="item-cost" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Стоимость
                                товара</label>
                            <input type="number" id="item-cost" name="item-cost"
                                   class="mt-1 block w-full dark:bg-gray-700 dark:text-gray-300" required>
                        </div>
                        <div class="mt-4">
                            <label for="quantity" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Количество</label>
                            <input type="number" id="quantity" name="quantity"
                                   class="mt-1 block w-full dark:bg-gray-700 dark:text-gray-300" required>
                        </div>
                        <div class="mt-4">
                            <button type="button" onclick="calculateTotalCost()"
                                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Рассчитать
                            </button>
                        </div>
                    </form>
                    <div id="total-cost" class="mt-4 text-lg font-semibold"></div>
                </div>
            </div>

            <!-- Раздел управления расходами -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Расходы</h3>
                    <a href="{{ route('expenses.create') }}"
                       class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-400 active:bg-blue-600 focus:outline-none focus:border-blue-600 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150 mb-4">
                        Добавить расход
                    </a>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Категория
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Сумма
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Дата
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Описание
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach(App\Models\Expense::where('user_id', Auth::id())->get() as $expense)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $expense->category->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ $expense->amount }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ $expense->date }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ $expense->description }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <!-- Раздел управления категориями -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold">Категории</h3>
                    <a href="{{ route('categories.create') }}"
                       class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-400 active:bg-blue-600 focus:outline-none focus:border-blue-600 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">Добавить
                        категорию</a>
                    <table class="table-auto w-full mt-4">
                        <thead>
                        <tr>
                            <th class="px-4 py-2">Название</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach(App\Models\Category::all() as $category)
                            <tr>
                                <td class="border px-4 py-2">{{ $category->name }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Раздел управления бюджетами -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold">Бюджеты</h3>
                    <a href="{{ route('budgets.create') }}"
                       class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-400 active:bg-blue-600 focus:outline-none focus:border-blue-600 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">Добавить
                        бюджет</a>
                    <table class="table-auto w-full mt-4">
                        <thead>
                        <tr>
                            <th class="px-4 py-2">Сумма</th>
                            <th class="px-4 py-2">Период</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach(App\Models\Budget::where('user_id', Auth::id())->get() as $budget)
                            <tr>
                                <td class="border px-4 py-2">{{ $budget->amount }}</td>
                                <td class="border px-4 py-2">{{ ucfirst($budget->period) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    function calculateTotalCost() {
        const itemCost = document.getElementById('item-cost').value;
        const quantity = document.getElementById('quantity').value;
        const totalCost = itemCost * quantity;
        document.getElementById('total-cost').innerText = `Общая стоимость: ${totalCost} руб.`;
    }
</script>
