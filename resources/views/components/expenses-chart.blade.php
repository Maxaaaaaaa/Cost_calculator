<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
    <div class="p-6 text-gray-900 dark:text-gray-100">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Расходы по категориям</h3>
            <div>
                <button id="sortYear" class="px-4 py-2 bg-blue-500 text-white rounded-md mr-2">За год</button>
                <button id="sortMonth" class="px-4 py-2 bg-blue-500 text-white rounded-md">За месяц</button>
            </div>
        </div>
        <div class="chart-container" style="position: relative; height:40vh; width:80vw">
            <canvas id="expensesChart" style="width: 95%; height: 95%;"></canvas>
        </div>
    </div>
</div>
