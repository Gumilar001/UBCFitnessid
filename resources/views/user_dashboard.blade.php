<x-app-layout>
    <div class="flex min-h-screen bg-gray-100 dark:bg-gray-900">
        <!-- Main Content -->
        <main class="flex-1 p-4 sm:p-6 lg:p-8 bg-gray-100 dark:bg-gray-900">
            <div class="mb-6">
                <h1 class="text-xl sm:text-2xl font-bold text-gray-800 dark:text-gray-100">
                    Selamat datang, {{ Auth::user()->name }}!
                </h1>
                <p class="text-sm sm:text-base text-gray-600 dark:text-gray-300">
                    Ini adalah halaman Landing Page USER UBCFitnessid.
                </p>
            </div>

</x-app-layout>
