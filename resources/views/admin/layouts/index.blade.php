<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-gray-100 font-sans">
    <!-- Sidebar -->
    <div class="flex h-screen">
      @include('admin.layouts.partials.sidebar')

        <!-- Main Content -->
        <div class="flex-1 ml-64">
            <!-- Header -->
          @include('admin.layouts.partials.header')

            <!-- Main Content Area -->
            <main class="p-6">
                <!-- Charts -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Line Chart -->
                    <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                        <h3 class="text-lg font-semibold mb-4">Monthly Sales</h3>
                        <canvas id="lineChart"></canvas>
                    </div>
                    <!-- Bar Chart -->
                    <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                        <h3 class="text-lg font-semibold mb-4">User Growth</h3>
                        <canvas id="barChart"></canvas>
                    </div>
                </div>

                <!-- Category Table -->
                <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h3 class="text-lg font-semibold mb-4">Category List</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left bg-white text-gray-900 rounded-lg shadow-md">
                            <thead class="bg-green-100">
                                <tr>
                                    <th class="px-6 py-3 font-bold text-gray-900">ID</th>
                                    <th class="px-6 py-3 font-bold text-gray-900">Category Name</th>
                                    <th class="px-6 py-3 font-bold text-gray-900">Description</th>
                                    <th class="px-6 py-3 font-bold text-gray-900">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="px-6 py-4">1</td>
                                    <td class="px-6 py-4">Electronics</td>
                                    <td class="px-6 py-4">Devices and gadgets</td>
                                    <td class="px-6 py-4">
                                        <button class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 mr-2">
                                            <i class="fas fa-edit mr-1"></i> Edit
                                        </button>
                                        <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                            <i class="fas fa-trash mr-1"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="px-6 py-4">2</td>
                                    <td class="px-6 py-4">Clothing</td>
                                    <td class="px-6 py-4">Fashion and apparel</td>
                                    <td class="px-6 py-4">
                                        <button class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 mr-2">
                                            <i class="fas fa-edit mr-1"></i> Edit
                                        </button>
                                        <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                            <i class="fas fa-trash mr-1"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="px-6 py-4">3</td>
                                    <td class="px-6 py-4">Books</td>
                                    <td class="px-6 py-4">Literature and education</td>
                                    <td class="px-6 py-4">
                                        <button class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 mr-2">
                                            <i class="fas fa-edit mr-1"></i> Edit
                                        </button>
                                        <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                            <i class="fas fa-trash mr-1"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>

            <!-- Footer -->
            @include('admin.layouts.partials.footer')
        </div>
    </div>

    <script>
        // Sidebar toggle functionality
        const toggleSidebar = document.getElementById('toggleSidebar');
        const sidebar = document.querySelector('aside');
        toggleSidebar.addEventListener('click', () => {
            sidebar.classList.toggle('hidden');
            document.querySelector('.flex-1').classList.toggle('ml-64');
            document.querySelector('.flex-1').classList.toggle('ml-0');
        });

        // Line Chart
        const lineChart = new Chart(document.getElementById('lineChart'), {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Sales ($)',
                    data: [12000, 19000, 15000, 25000, 22000, 30000],
                    borderColor: '#3B82F6',
                    backgroundColor: 'rgba(59, 130, 246, 0.2)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { borderColor: '#4B5563' },
                        ticks: { color: '#9CA3AF' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#9CA3AF' }
                    }
                },
                plugins: {
                    legend: { labels: { color: '#9CA3AF' } }
                }
            }
        });

        // Bar Chart
        const barChart = new Chart(document.getElementById('barChart'), {
            type: 'bar',
            data: {
                labels: ['Q1', 'Q2', 'Q3', 'Q4'],
                datasets: [{
                    label: 'New Users',
                    data: [500, 800, 1200, 1800],
                    backgroundColor: '#22C55E', // Vibrant emerald green
                    borderColor: '#16A34A', // Slightly darker green for border
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { borderColor: '#4B5563' },
                        ticks: { color: '#9CA3AF' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#9CA3AF' }
                    }
                },
                plugins: {
                    legend: { labels: { color: '#9CA3AF' } }
                }
            }
        });
    </script>
</body>
</html>