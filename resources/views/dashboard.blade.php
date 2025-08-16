<x-app-layout>
    <div class="flex min-h-screen bg-gray-100 dark:bg-gray-900">
        <!-- Main Content -->
        <main class="flex-1 p-4 sm:p-6 lg:p-8 bg-gray-100 dark:bg-gray-900">
            <div class="mb-6">
                <h1 class="text-xl sm:text-2xl font-bold text-gray-800 dark:text-gray-100">
                    Selamat datang, {{ Auth::user()->name }}!
                </h1>
                <p class="text-sm sm:text-base text-gray-600 dark:text-gray-300">
                    Ini adalah halaman Landing Page UBCFitnessid.
                </p>
            </div>

            <!-- Ringkasan -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-6">
                <!-- Pendapatan Bulanan -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 sm:p-6">
                    <h2 class="text-base sm:text-lg font-semibold text-gray-700 dark:text-gray-200">Pendapatan Bulanan</h2>
                    <p class="mt-3 sm:mt-4 text-xl sm:text-2xl font-bold text-green-600">
                        Rp {{ number_format($pendapatanBulanan, 0, ',', '.') }}
                    </p>
                </div>

                <!-- Membership -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 sm:p-6">
                    <h2 class="text-base sm:text-lg font-semibold text-gray-700 dark:text-gray-200">Membership</h2>
                    <p class="mt-3 sm:mt-4 text-xl sm:text-2xl font-bold text-blue-600">
                        {{ $jumlahPengguna }}
                    </p>
                </div>

                <!-- Pengeluaran -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 sm:p-6">
                    <h2 class="text-base sm:text-lg font-semibold text-gray-700 dark:text-gray-200">Pengeluaran</h2>
                    <p class="mt-3 sm:mt-4 text-xl sm:text-2xl font-bold text-red-600">
                        Rp {{ number_format($pengeluaran, 0, ',', '.') }}
                    </p>
                </div>
            </div>

            <!-- Grafik -->
            <div class="grid gap-4 sm:gap-6">
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 sm:p-6">
                    <h2 class="text-base sm:text-lg font-semibold text-gray-700 dark:text-gray-200 mb-3 sm:mb-4">
                        Ringkasan Keuangan ({{ date('Y') }})
                    </h2>
                    <canvas id="barChart" height="100"></canvas>
                </div>
            </div>
        </main>
    </div>

    <!-- Chart.js -->
   <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('barChart').getContext('2d');
    const incomeData = @json($incomeByMonth->values()->toArray());

    // Warna batang
    let barColors = Array(12).fill('rgba(156, 163, 175, 0.5)'); // Warna abu-abu default
    const currentMonth = new Date().getMonth();
    barColors[currentMonth] = 'rgba(37, 99, 235, 0.9)'; // Warna biru untuk bulan ini

    // Membuat chart
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'], // Label Bulan
            datasets: [{
                label: 'Pendapatan',
                data: incomeData, // Data Pendapatan
                backgroundColor: barColors, // Warna untuk tiap bar
                borderRadius: 12, // Menambahkan radius pada sudut bar
                borderColor: '#1D4ED8', // Border berwarna biru
                borderWidth: 2, // Lebar border
                hoverBackgroundColor: 'rgba(37, 99, 235, 0.8)', // Warna hover
                hoverBorderColor: '#1D4ED8', // Warna border saat hover
                hoverBorderWidth: 3 // Lebar border saat hover
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true, // Menampilkan legenda
                    position: 'top', // Menempatkan legenda di atas
                    labels: {
                        font: {
                            size: 14,
                            weight: 'bold',
                        },
                        color: '#4B5563' // Warna teks legenda
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            // Menampilkan format angka yang lebih informatif pada tooltip
                            return 'Rp ' + tooltipItem.raw.toLocaleString();
                        }
                    },
                    backgroundColor: 'rgba(37, 99, 235, 0.9)', // Warna tooltip
                    titleColor: '#ffffff', // Warna judul tooltip
                    bodyColor: '#ffffff', // Warna teks body tooltip
                    borderColor: 'rgba(37, 99, 235, 0.9)', // Border warna tooltip
                    borderWidth: 1, // Border lebar tooltip
                    displayColors: false, // Menyembunyikan warna bar pada tooltip
                }
            },
            scales: {
                x: {
                    ticks: {
                        font: {
                            size: 12, // Ukuran font pada sumbu X
                            weight: 'bold',
                        },
                        color: '#4B5563' // Warna teks pada sumbu X
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString(); // Format angka dengan "Rp"
                        },
                        font: {
                            size: 14, // Ukuran font pada sumbu Y
                            weight: 'bold',
                        },
                        color: '#4B5563' // Warna teks pada sumbu Y
                    }
                }
            },
            // Menambahkan animasi untuk chart
            animation: {
                duration: 1000, // Durasi animasi
                easing: 'easeOutBounce' // Jenis animasi
            }
        }
    });
</script>

</x-app-layout>
