<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Edit User</h2>
    </x-slot>

    <div class="max-w-2xl mx-auto p-6 bg-white shadow-md rounded-lg">
        <form action="{{ route('users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-medium">Nama</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border rounded p-2">
            </div>

            <div class="mt-4">
                <label class="block font-medium">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border rounded p-2">
            </div>

            <div class="mt-4">
                <label class="block font-medium">No. HP</label>
                <input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}" class="w-full border rounded p-2">
            </div>

            <div class="mt-4">
                <label class="block font-medium">No. Darurat</label>
                <input type="text" name="no_emergency" value="{{ old('no_emergency', $user->no_emergency) }}" class="w-full border rounded p-2">
            </div>

            <div class="mt-4">
                <label class="block font-medium">Password (kosongkan jika tidak ingin diubah)</label>
                <input type="password" name="password" class="w-full border rounded p-2">
            </div>

            <div class="mt-4">
                <label class="block font-medium">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="w-full border rounded p-2">
            </div>

            <div class="mt-4">
                <label class="block font-medium">Role</label>
                <select name="role" class="w-full border rounded p-2">
                    @foreach(['admin','staff','user'] as $role)
                        <option value="{{ $role }}" {{ $user->role === $role ? 'selected' : '' }}>
                            {{ ucfirst($role) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mt-4">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Update</button>
            </div>
        </form>
    </div>
</x-app-layout>
