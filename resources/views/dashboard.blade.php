@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('components.expenses-chart')
            @include('components.expenses-table')
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('expensesChart').getContext('2d');
            let categoryData = @json($categoryData);
            let budget = @json($budget);
            let totalIncome = @json($totalIncome);

            const budgetAmount = parseFloat(budget.amount) + parseFloat(totalIncome);
            const labels = Object.keys(categoryData);
            const expenses = Object.values(categoryData).map(value => parseFloat(value));
            const totalExpenses = expenses.reduce((sum, value) => sum + value, 0);
            const remainingBudget = budgetAmount - totalExpenses;

            labels.push('Remaining Budget');
            expenses.push(remainingBudget);

            const backgroundColors = [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(75, 192, 75, 0.2)'
            ];

            const borderColors = [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 75, 1)'
            ];

            let chart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Expenses by Category',
                        data: expenses,
                        backgroundColor: backgroundColors,
                        borderColor: borderColors,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'left',
                        },
                        tooltip: {
                            callbacks: {
                                label: function (tooltipItem) {
                                    return tooltipItem.label + ': ' + tooltipItem.raw + ' zł.';
                                }
                            }
                        }
                    }
                }
            });

            document.getElementById('sortYear').addEventListener('click', function () {
                console.log('Sorting by year');
                fetch('/dashboard/yearly-expenses')
                    .then(response => response.json())
                    .then(data => {
                        updateChart(data.expenses, data.budget, data.totalIncome);
                    });
            });

            document.getElementById('sortMonth').addEventListener('click', function () {
                console.log('Sorting by month');
                fetch('/dashboard/monthly-expenses')
                    .then(response => response.json())
                    .then(data => {
                        updateChart(data.expenses, data.budget, data.totalIncome);
                    });
            });

            function fetchData(period) {
                console.log('Fetching data for period:', period);
                fetch(`/dashboard/expenses?period=${period}`)
                    .then(response => response.json())
                    .then(data => {
                        updateChart(data.expenses, data.budget, data.totalIncome);
                    });
            }

            function updateChart(expenses, budget, totalIncome) {
                let filteredExpenses = {};

                for (const expense of expenses) {
                    const category = expense.category.name;
                    if (!filteredExpenses[category]) {
                        filteredExpenses[category] = 0;
                    }
                    filteredExpenses[category] += parseFloat(expense.amount);
                }

                const labels = Object.keys(filteredExpenses);
                const expensesData = Object.values(filteredExpenses);

                const budgetAmount = parseFloat(budget.amount) + parseFloat(totalIncome);
                const totalExpenses = expensesData.reduce((sum, value) => sum + value, 0);
                const remainingBudget = budgetAmount - totalExpenses;

                labels.push('Remaining Budget');
                expensesData.push(remainingBudget);

                chart.data.labels = labels;
                chart.data.datasets[0].data = expensesData;
                chart.update();
            }
        });
    </script>
@endpush
