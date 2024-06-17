@extends('layouts.app') // Extends the 'app' layout

@section('title', 'Dashboard') // Sets the title of the page to 'Dashboard'

@section('content') // Defines the content section of the page
<div class="py-12"> // Adds padding to the top and bottom
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> // Sets the maximum width and horizontal padding
        @include('components.expenses-chart') // Includes the expenses chart component
        @include('components.expenses-table') // Includes the expenses table component
    </div>
</div>
@endsection

@push('scripts') // Pushes scripts to the stack
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script> // Includes Chart.js library
<script>
    document.addEventListener('DOMContentLoaded', function () { // Executes when the DOM is fully loaded
        const ctx = document.getElementById('expensesChart').getContext('2d'); // Gets the context of the expenses chart canvas
        let categoryData = @json($categoryData); // Converts PHP variable to JSON
        let budget = @json($budget); // Converts PHP variable to JSON
        let totalIncome = @json($totalIncome); // Converts PHP variable to JSON

        const budgetAmount = parseFloat(budget.amount) + parseFloat(totalIncome); // Calculates the total budget amount
        const labels = Object.keys(categoryData); // Extracts category names
        const expenses = Object.values(categoryData).map(value => parseFloat(value)); // Extracts and parses expense values
        const totalExpenses = expenses.reduce((sum, value) => sum + value, 0); // Calculates the total expenses
        const remainingBudget = budgetAmount - totalExpenses; // Calculates the remaining budget

        labels.push('Remaining Budget'); // Adds 'Remaining Budget' to labels
        expenses.push(remainingBudget); // Adds remaining budget to expenses

        const backgroundColors = [ // Defines background colors for the chart
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(75, 192, 75, 0.2)'
        ];

        const borderColors = [ // Defines border colors for the chart
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(75, 192, 75, 1)'
        ];

        let chart = new Chart(ctx, { // Creates a new Chart.js chart
            type: 'doughnut', // Sets the chart type to 'doughnut'
            data: {
                labels: labels, // Sets the labels for the chart
                datasets: [{
                    label: 'Expenses by Category', // Sets the dataset label
                    data: expenses, // Sets the data for the chart
                    backgroundColor: backgroundColors, // Sets the background colors
                    borderColor: borderColors, // Sets the border colors
                    borderWidth: 1 // Sets the border width
                }]
            },
            options: {
                responsive: true, // Makes the chart responsive
                maintainAspectRatio: false, // Disables maintaining aspect ratio
                plugins: {
                    legend: {
                        position: 'left', // Positions the legend to the left
                    },
                    tooltip: {
                        callbacks: {
                            label: function (tooltipItem) { // Customizes the tooltip label
                                return tooltipItem.label + ': ' + tooltipItem.raw + ' zł.';
                            }
                        }
                    }
                }
            }
        });

        document.getElementById('sortYear').addEventListener('click', function () { // Adds event listener for sorting by year
            console.log('Sorting by year');
            fetch('/dashboard/yearly-expenses') // Fetches yearly expenses data
                .then(response => response.json())
                .then(data => {
                    updateChart(data.expenses, data.budget, data.totalIncome); // Updates the chart with new data
                });
        });

        document.getElementById('sortMonth').addEventListener('click', function () { // Adds event listener for sorting by month
            console.log('Sorting by month');
            fetch('/dashboard/monthly-expenses') // Fetches monthly expenses data
                .then(response => response.json())
                .then(data => {
                    updateChart(data.expenses, data.budget, data.totalIncome); // Updates the chart with new data
                });
        });

        function fetchData(period) { // Fetches data for a specific period
            console.log('Fetching data for period:', period);
            fetch(`/dashboard/expenses?period=${period}`) // Fetches expenses data for the given period
                .then(response => response.json())
                .then(data => {
                    updateChart(data.expenses, data.budget, data.totalIncome); // Updates the chart with new data
                });
        }

        function updateChart(expenses, budget, totalIncome) { // Updates the chart with new data
            let filteredExpenses = {};

            for (const expense of expenses) { // Aggregates expenses by category
                const category = expense.category.name;
                if (!filteredExpenses[category]) {
                    filteredExpenses[category] = 0;
                }
                filteredExpenses[category] += parseFloat(expense.amount);
            }

            const labels = Object.keys(filteredExpenses); // Extracts category names
            const expensesData = Object.values(filteredExpenses); // Extracts expense values

            const budgetAmount = parseFloat(budget.amount) + parseFloat(totalIncome); // Calculates the total budget amount
            const totalExpenses = expensesData.reduce((sum, value) => sum + value, 0); // Calculates the total expenses
            const remainingBudget = budgetAmount - totalExpenses; // Calculates the remaining budget

            labels.push('Remaining Budget'); // Adds 'Remaining Budget' to labels
            expensesData.push(remainingBudget); // Adds remaining budget to expenses

            chart.data.labels = labels; // Updates chart labels
            chart.data.datasets[0].data = expensesData; // Updates chart data
            chart.update(); // Updates the chart
        }
    });
</script>
@endpush
