<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900 dark:text-gray-100">
        <h3 class="text-lg font-semibold mb-4">Expenses/Incomes</h3>
        <a href="{{ route('expenses.create') }}" class="inline-flex items-center px-4 py-2 border border-blue-500 bg-blue-500 text-white rounded-md hover:bg-blue-600 hover:text-white mr-2 mb-4">
            Add Expense
        </a>
        <a href="{{ route('incomes.create') }}" class="inline-flex items-center px-4 py-2 border border-green-500 bg-green-500 text-white rounded-md hover:bg-green-600 hover:text-white mb-4">
            Add Income
        </a>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Category
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Amount
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Date
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Description
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @foreach(App\Models\Expense::where('user_id', Auth::id())->get() as $expense)
                    <tr id="expense-{{ $expense->id }}">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">{{ $expense->category->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $expense->amount }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $expense->date }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $expense->description }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                            <button onclick="deleteExpense({{ $expense->id }})" class="px-4 py-2 bg-red-500 text-white rounded-md">Delete</button>
                        </td>
                    </tr>
                @endforeach
                @foreach(App\Models\Income::where('user_id', Auth::id())->get() as $income)
                    <tr id="income-{{ $income->id }}">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">{{ $income->category->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $income->amount }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $income->date }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $income->description }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                            <button onclick="deleteIncome({{ $income->id }})" class="px-4 py-2 bg-red-500 text-white rounded-md">Delete</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function deleteExpense(expenseId) {
            if (confirm('Are you sure you want to delete this expense?')) {
                fetch(`/expenses/${expenseId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                    .then(response => {
                        if (response.ok) {
                            document.getElementById(`expense-${expenseId}`).remove();
                        } else {
                            alert('Error deleting expense.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error deleting expense.');
                    });
            }
        }

        function deleteIncome(incomeId) {
            if (confirm('Are you sure you want to delete this income?')) {
                fetch(`/incomes/${incomeId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                    .then(response => {
                        if (response.ok) {
                            document.getElementById(`income-${incomeId}`).remove();
                        } else {
                            alert('Error deleting income.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error deleting income.');
                    });
            }
        }
    </script>
@endpush
