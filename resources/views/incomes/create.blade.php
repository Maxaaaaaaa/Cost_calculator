@extends('layouts.app')

@section('title', 'Add Income')

@section('content')
    <!-- Main container for the content -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Container for the form and its elements -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Title of the form -->
                    <h3 class="text-lg font-semibold mb-4">Add Income</h3>
                    <!-- Navigation buttons for adding expense or income -->
                    <div class="flex justify-between items-center mb-4">
                        <div class="flex space-x-2">
                            <!-- Button to navigate to the expense creation form -->
                            <a href="{{ route('expenses.create') }}" class="inline-flex items-center px-4 py-2 border border-blue-500 bg-blue-500 text-white rounded-md hover:bg-blue-600 hover:text-white mr-2">
                                Expense
                            </a>
                            <!-- Button to navigate to the income creation form -->
                            <a href="{{ route('incomes.create') }}" class="inline-flex items-center px-4 py-2 border border-green-500 bg-green-500 text-white rounded-md hover:bg-green-600 hover:text-white">
                                Income
                            </a>
                        </div>
                    </div>
                    <!-- Form to add a new income -->
                    <form action="{{ route('incomes.store') }}" method="POST">
                        @csrf
                        <!-- Category selection dropdown -->
                        <div class="mb-4">
                            <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category</label>
                            <select id="category" name="category" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="Salary">Salary</option>
                                <option value="Scholarship">Scholarship</option>
                                <option value="Refunds">Refunds</option>
                                <option value="Investments">Investments</option>
                                <option value="Gifts">Gifts</option>
                                <option value="Transfers">Transfers</option>
                                <option value="Others">Others</option>
                            </select>
                        </div>
                        <!-- Field to add a new category if "Others" is selected -->
                        <div class="mb-4" id="newCategoryField" style="display: none;">
                            <label for="new_category" class="block text-sm font-medium text-gray-700 dark:text-gray-300">New Category</label>
                            <input type="text" name="new_category" id="new_category" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        </div>
                        <!-- Field to input the amount of the income -->
                        <div class="mb-4">
                            <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Amount</label>
                            <input type="number" name="amount" id="amount" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" required>
                        </div>
                        <!-- Field to input the date of the income -->
                        <div class="mb-4">
                            <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date</label>
                            <input type="date" name="date" id="date" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" required>
                        </div>
                        <!-- Field to input the description of the income -->
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                            <textarea name="description" id="description" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"></textarea>
                        </div>
                        <!-- Submit button to add the income -->
                        <div class="flex justify-end">
                            <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-md">Add</button>
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

            // Show or hide the new category field based on the selected category
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
