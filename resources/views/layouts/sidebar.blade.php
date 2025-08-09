<!-- resources/views/layouts/sidebar.blade.php -->
<nav class="bg-white dark:bg-gray-900 w-64 h-screen p-4 shadow">
    <ul>
        <li class="mb-2">
            <a href="#" class="block py-2 px-4 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">Dashboard</a>
        </li>
        <li class="mb-2">
            <a href="#" class="block py-2 px-4 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">Users</a>
        </li>
        <li class="mb-2">
            <button
                onclick="toggleSubmenu('management-submenu')"
                class="w-full flex justify-between items-center py-2 px-4 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200"
            >
                Management
                <svg class="w-4 h-4 transition-transform" id="management-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <ul id="management-submenu" class="hidden pl-4 mt-2">
                <li class="mb-2">
                    <a href="{{ route('memberships.index') }}" class="block py-2 px-4 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">Membership</a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('user-memberships.index') }}" class="block py-2 px-4 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">User Membership</a>
                </li>
            </ul>
        </li>
        <li class="mb-2">
            <a href="{{ route('transactions.index') }}" class="block py-2 px-4 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">Transaction</a>
        </li>
        <li class="mb-2">
            <a href="#" class="block py-2 px-4 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">Settings</a>
        </li>
    </ul>
</nav>
