@php
    $role = Auth::user()->role ?? null;
@endphp

<nav class="bg-white dark:bg-gray-900 w-64 h-screen p-4 shadow lg:block hidden" id="sidebar">
    <div class="flex justify-between items-center">
        <!-- <div class="text-lg font-semibold text-gray-700 dark:text-gray-200">Dashboard</div> -->
        <!-- Button untuk membuka sidebar (Mobile) -->
        <button id="menu-toggle" class="lg:hidden text-gray-700 dark:text-gray-200">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 6h16M4 12h16M4 18h16" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
    </div>
    <ul>

        {{-- Menu khusus ADMIN --}}
        @if($role === 'admin')
            <li class="mb-2">
                <a href="{{ route('dashboard') }}" class="block py-2 px-4 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">
                    Dashboard
                </a>
            </li>
            <li class="mb-2">
                <a href="{{ route('users.index') }}" class="block py-2 px-4 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">
                    Users
                </a>
            </li>

            <li class="mb-2">
                <a href="{{ route('transactions.index') }}" class="block py-2 px-4 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">
                    Transaction
                </a>
            </li>

            <li class="mb-2">
                <button
                    onclick="toggleSubmenu('management-submenu')"
                    class="w-full flex justify-between items-center py-2 px-4 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">
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
                    <li class="mb-2">
                        <a href="{{ route('trainer.dashboard') }}" class="block py-2 px-4 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">Trainers</a>
                    </li>
                </ul>
            </li>
            <li class="mb-2">
                <a href="{{ route('products.index') }}" class="block py-2 px-4 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">
                    Products
                </a>
        @endif

        {{-- Menu khusus STAFF --}} 
        @if($role === 'staff')
            <li class="mb-2">
                <a href="{{ route('shift.index') }}" class="block py-2 px-4 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">
                    Dashboard
                </a>
            </li>
            <li class="mb-2">
                <a href="{{ route('staff.users.index') }}" class="block py-2 px-4 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">
                    Users
                </a>
            </li>
            <li class="mb-2">
                <button
                    onclick="toggleSubmenu('management-submenu')"
                    class="w-full flex justify-between items-center py-2 px-4 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">
                    Management
                    <svg class="w-4 h-4 transition-transform" id="management-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <ul id="management-submenu" class="hidden pl-4 mt-2">
                     <li class="mb-2">
                        <a href="{{ route('staff.transactions.index') }}" class="block py-2 px-4 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">
                            Transaction
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('user-memberships.index') }}" class="block py-2 px-4 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">User Membership</a>
                    </li>            
                </ul>
            </li>
        @endif

        {{-- Menu khusus USER --}}
        @if($role === 'user')
            <li class="mb-2">
                <a href="{{ route('user_dashboard') }}" class="block py-2 px-4 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">
                    Dashboard
                </a>
            </li>
            <li class="mb-2">
                <a href="{{ route('user.my-memberships') }}" class="block py-2 px-4 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">
                    My Memberships
                </a>
            </li>
            <li class="mb-2">
                <a href="{{ route('user.my-transactions') }}" class="block py-2 px-4 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">
                    My Transactions
                </a>
            </li>
            <li class="mb-2">
                <a href="{{ route('trainer.dashboard') }}" class="block py-2 px-4 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">Trainers</a>
            </li>
        @endif

        @if($role === 'personal trainer')
            <li class="mb-2">
                <a href="{{ route('pt_dashboard') }}" class="block py-2 px-4 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">
                    Dashboard
                </a>
            <li class="mb-2">
                <a href="{{ route('trainer.dashboard') }}" class="block py-2 px-4 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">Trainers</a>
            </li>
        @endif

        {{-- Menu Settings (semua role) --}}
        <li class="mb-2">
            <a href="{{ route('profile.edit') }}" class="block py-2 px-4 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">
                Settings
            </a>
        </li>
    </ul>
</nav>
<!-- Sidebar Mobile -->


<script>
    function toggleSubmenu(id) {
        const submenu = document.getElementById(id);
        const icon = document.getElementById(id.replace('submenu', 'icon'));
        submenu.classList.toggle('hidden');
        icon.classList.toggle('rotate-180');
    }

    const menuToggle = document.getElementById('menu-toggle');
    const mobileSidebar = document.getElementById('mobile-sidebar');

    menuToggle.addEventListener('click', () => {
        mobileSidebar.classList.toggle('hidden');
    });
</script>
