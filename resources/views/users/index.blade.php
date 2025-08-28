<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Manajemen User</h2>
    </x-slot>

    <div class="max-w-6xl mx-auto mt-6">
        <div class="flex items-center justify-between mb-4">
            @auth
                @if(Auth::user()->role === 'admin' || Auth::user()->role === 'staff')
                    <a href="{{ route('users.create') }}" class="bg-blue-600 hover:bg-blue-800 text-white px-4 py-2 rounded">Tambah User</a>
                @endif
            @endauth

            <form method="GET" action="{{ route('users.index') }}" class="flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama/email" class="border rounded p-2">
                
                <select name="role" class="border rounded p-2 pr-8">
                    <option value="all" {{ request('role') === 'all' ? 'selected' : '' }}>Semua Role</option>
                    @foreach($roles as $role)
                        <option value="{{ $role }}" {{ request('role') === $role ? 'selected' : '' }}>
                            {{ ucfirst($role) }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Filter</button>
            </form>
        </div>

        @if(session('success'))
            <div class="bg-green-200 text-green-800 p-2 rounded mt-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full mt-4 border">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-2 border">Nama</th>
                    <th class="p-2 border">Email</th>                    
                    <th class="p-2 border">Kontak</th>                    
                    <th class="p-2 border">Kontak Emergency</th>                    
                    <th class="p-2 border">Role</th>
                    <th class="p-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td class="p-2 border">{{ $user->name }}</td>
                    <td class="p-2 border">{{ $user->email }}</td>
                    <td class="p-2 border">{{ $user->no_hp }}</td>
                    <td class="p-2 border">{{ $user->no_emergency }}</td>
                    <td class="p-2 border">{{ ucfirst($user->role) }}</td>
                    <td class="p-2 border flex gap-2">
                        <a href="{{ route('users.edit', $user) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded">Edit</a>
                        <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Yakin hapus user ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</x-app-layout>
