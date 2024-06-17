<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
    <div class="p-6 text-gray-900 dark:text-gray-100">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Expenses by category</h3>
            <div>
                <button id="sortYear" class="px-4 py-2 border border-blue-500 bg-blue-500 text-white rounded-md hover:bg-blue-600 hover:text-white mr-2">This Year</button>
                <button id="sortMonth" class="px-4 py-2 border border-blue-500 bg-blue-500 text-white rounded-md hover:bg-blue-600 hover:text-white mr-2">This Month</button>

            </div>
        </div>
        <div class="chart-container" style="position: relative; height:40vh; width:80vw">
            <canvas id="expensesChart" style="width: 95%; height: 95%;"></canvas>
        </div>
    </div>
</div>

<!-- Modal -->
<div x-data="{ open: false }">
    <div x-show="open" class="fixed z-10 inset-0 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="open" class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="open" class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100" id="modal-title">
                                Выберите период
                            </h3>
                            <div class="mt-2">
                                <button @click="fetchData('last-month')" class="px-4 py-2 border border-blue-500 bg-blue-500 text-white rounded-md hover:bg-blue-600 hover:text-white mb-2">Last Month</button>
                                <button @click="fetchData('last-year')" class="px-4 py-2 border border-blue-500 bg-blue-500 text-white rounded-md hover:bg-blue-600 hover:text-white mb-2">Last Year</button>
                                <button @click="fetchData('this-week')" class="px-4 py-2 border border-blue-500 bg-blue-500 text-white rounded-md hover:bg-blue-600 hover:text-white mb-2">This Week</button>
                                <button @click="fetchData('last-week')" class="px-4 py-2 border border-blue-500 bg-blue-500 text-white rounded-md hover:bg-blue-600 hover:text-white mb-2">Last Week</button>
                                <div class="mt-4">
                                    <label for="month" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Выберите месяц</label>
                                    <select id="month" name="month" @change="fetchData($event.target.value)" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                        <option value="jan">Jan</option>
                                        <option value="feb">Feb</option>
                                        <option value="mar">Mar</option>
                                        <option value="apr">Apr</option>
                                        <option value="may">May</option>
                                        <option value="jun">Jun</option>
                                        <option value="jul">Jul</option>
                                        <option value="aug">Aug</option>
                                        <option value="sep">Sep</option>
                                        <option value="oct">Oct</option>
                                        <option value="nov">Nov</option>
                                        <option value="dec">Dec</option>
                                    </select>
                                </div>
                                <div class="mt-4">
                                    <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Выберите дату</label>
                                    <input type="date" id="date" name="date" @change="fetchData($event.target.value)" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button @click="open = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Закрыть
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function fetchData(period) {
        console.log('Fetching data for period:', period);
        // Здесь вы можете добавить логику для получения данных на основе выбранного периода
        // Например, отправить запрос на сервер и обновить график
        fetch(`/dashboard/expenses?period=${period}`)
            .then(response => response.json())
            .then(data => {
                updateChart(data.expenses, data.budget);
            });
    }
</script>
