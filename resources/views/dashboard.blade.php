@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('components.expenses-chart')
            @include('components.expenses-table')
            @include('components.budgets-table')
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const categoryData = @json($categoryData);
            const categoryList = document.getElementById('categoryList');

            console.log('Category Data:', categoryData); // Проверка данных

            // Отображение категорий
            for (const [category, amount] of Object.entries(categoryData)) {
                const listItem = document.createElement('li');
                listItem.textContent = `${category}: ${amount} руб.`;
                categoryList.appendChild(listItem);
            }
        });
    </script>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('expensesChart').getContext('2d');
            const categoryData = @json($categoryData);
            const budget = @json($budget); // Получаем бюджет из контроллера

            // Проверка типа данных и значений
            console.log('Initial Budget:', budget); // Проверка бюджета
            console.log('Type of Budget:', typeof budget);
            console.log('Initial Category Data:', categoryData); // Проверка данных категорий
            console.log('Type of Category Data:', typeof categoryData);

            // Извлечение значения amount и period из объекта budget
            const budgetAmount = parseFloat(budget.amount);
            const budgetPeriod = budget.period;

            console.log('Budget Amount:', budgetAmount); // Проверка значения amount
            console.log('Budget Period:', budgetPeriod); // Проверка значения period

            const labels = Object.keys(categoryData);
            const expenses = Object.values(categoryData).map(value => parseFloat(value)); // Преобразуем значения расходов в числа

            // Проверка преобразованных значений
            console.log('Labels:', labels);
            console.log('Expenses:', expenses);

            const totalExpenses = expenses.reduce((sum, value) => sum + value, 0);

            // Проверка общей суммы расходов
            console.log('Total Expenses Calculated:', totalExpenses);

            const remainingBudget = budgetAmount - totalExpenses;

            // Проверка оставшегося бюджета
            console.log('Remaining Budget Calculated:', remainingBudget);

            // Add the remaining budget to the data
            labels.push('Remaining Budget');
            expenses.push(remainingBudget);

            // Проверка финальных данных
            console.log('Final Labels:', labels);
            console.log('Final Expenses:', expenses);

            // Цвета для категорий и оставшегося бюджета
            const backgroundColors = [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(75, 192, 192, 0.2)', // Цвет для категорий
                'rgba(75, 192, 75, 0.2)' // Зеленый цвет для оставшегося бюджета
            ];

            const borderColors = [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(75, 192, 192, 1)', // Цвет для категорий
                'rgba(75, 192, 75, 1)' // Зеленый цвет для оставшегося бюджета
            ];

            let chart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Расходы по категориям',
                        data: expenses,
                        backgroundColor: backgroundColors,
                        borderColor: borderColors,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: false,
                    maintainAspectRatio: false, // Отключение сохранения соотношения сторон
                    plugins: {
                        legend: {
                            position: 'left', // Изменено положение легенды
                        },
                        tooltip: {
                            callbacks: {
                                label: function (tooltipItem) {
                                    return tooltipItem.label + ': ' + tooltipItem.raw + ' руб.';
                                }
                            }
                        }
                    }
                }
            });

            // Обработчики событий для кнопок сортировки
            document.getElementById('sortYear').addEventListener('click', function () {
                // Логика для сортировки данных за год
                console.log('Sorting by year');
                // Обновление данных диаграммы
                chart.data.labels = labels; // Обновите метки и данные в зависимости от логики сортировки
                chart.data.datasets[0].data = expenses; // Обновите данные в зависимости от логики сортировки
                chart.update();
            });

            document.getElementById('sortMonth').addEventListener('click', function () {
                // Логика для сортировки данных за месяц
                console.log('Sorting by month');
                // Обновление данных диаграммы
                chart.data.labels = labels; // Обновите метки и данные в зависимости от логики сортировки
                chart.data.datasets[0].data = expenses; // Обновите данные в зависимости от логики сортировки
                chart.update();
            });
        });
    </script>
@endpush
