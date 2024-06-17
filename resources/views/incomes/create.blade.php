@extends('layouts.app')

@section('title', 'Добавить доход')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Добавить</h3>
                    <div class="flex justify-between items-center mb-2">
                        <a href="{{ route('expenses.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded-md">Расходы</a>
                        <a href="{{ route('incomes.create') }}" class="px-4 py-2 bg-green-500 text-white rounded-md">Доходы</a>
                    </div>
                    <form action="{{ route('incomes.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Категория</label>
                            <select id="category" name="category" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                @foreach($categories as $category)
                                    <option value="{{ $category }}">{{ $category }}</option>
                                @endforeach
                                <option value="Others">Others</option>
                            </select>
                        </div>
                        <div class="mb-4" id="newCategoryField" style="display: none;">
                            <label for="new_category" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Новая категория</label>
                            <input type="text" name="new_category" id="new_category" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        </div>
                        <div class="mb-4">
                            <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Сумма</label>
                            <input type="number" name="amount" id="amount" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" required>
                        </div>
                        <div class="mb-4">
                            <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Дата</label>
                            <input type="date" name="date" id="date" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" required>
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Описание</label>
                            <textarea name="description" id="description" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"></textarea>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-md">Добавить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const categorySelect = document.getElementById('category');
            const newCategoryField = document.getElementById('newCategoryField');

            categorySelect.addEventListener('change', function () {
                if (categorySelect.value === 'Others') {
                    newCategoryField.style.display = 'block';
                } else {
                    newCategoryField.style.display = 'none';
                }
            });
        });
    </script>
@endpush
