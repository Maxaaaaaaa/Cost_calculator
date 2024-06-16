<!-- resources/views/dashboard.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Cost Calculator') }}
        </h2>
    </x-slot>

    @section('title', 'Cost Calculator')

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
        </div>
    </div>
</x-app-layout>

<script>
    function calculateTotalCost() {
        const itemCost = document.getElementById('item-cost').value;
        const quantity = document.getElementById('quantity').value;
        const totalCost = itemCost * quantity;
        document.getElementById('total-cost').innerText = `Общая стоимость: ${totalCost} руб.`;
    }
</script>
