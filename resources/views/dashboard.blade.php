<x-app-layout>
    <div class="flex min-h-screen bg-gray-100 dark:bg-gray-900">
        <!-- Sidebar -->
        <aside class="w-64 bg-white dark:bg-gray-800 shadow-md">
            <div class="p-6">
                <img src="/images/mplogo.png" alt="Logo" class="w-24 mx-auto mb-4">
                <h3 class="text-lg font-bold text-center text-gray-800 dark:text-gray-200 mb-6">UBCFitnessid</h3>
                <nav>
                    <ul>
                        <li class="mb-2">
                            <a href="#" class="block py-2 px-4 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">Dashboard</a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="block py-2 px-4 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">Users</a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('memberships.index') }}" class="block py-2 px-4 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">Membership</a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('user-memberships.index') }}" class="block py-2 px-4 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">User Membership</a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('transactions.index') }}" class="block py-2 px-4 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">Transaction</a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="block py-2 px-4 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">Settings</a>
                        </li>
                        <li class="mt-8">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left py-2 px-4 rounded hover:bg-red-100 dark:hover:bg-red-900 text-red-600 dark:text-red-400">Logout</button>
                            </form>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Selamat datang, {{ Auth::user()->name }}!</h1>
                <p class="text-gray-600 dark:text-gray-300">Ini adalah halaman admin panel UBCFitnessid.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Card 1 -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-2">Statistik Pengguna</h2>
                    <p class="text-3xl font-bold text-blue-600 dark:text-blue-400"></p>
                </div>
                <!-- Card 2 -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-2">Transaksi</h2>
                    <p class="text-3xl font-bold text-green-600 dark:text-green-400">Rp </p>
                </div>
                <!-- Card 3 -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-2">Aktivitas Terbaru</h2>
                    <ul class="text-gray-600 dark:text-gray-300 text-sm">
                        <li>- User A mendaftar</li>
                        <li>- User B melakukan pembayaran</li>
                        <li>- User C update profil</li>
                    </ul>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
