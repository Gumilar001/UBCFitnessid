<x-app-layout>
    <!-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Tambah User</h2>
    </x-slot> -->

    <div class="max-w-2xl mx-auto p-6 bg-white shadow-md rounded-lg">
        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            <div>
                <label class="block font-medium">Nama</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded p-2">
                @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mt-4">
                <label class="block font-medium">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded p-2">
                @error('email') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mt-4">
                <label class="block font-medium">Password</label>
                <input type="password" name="password" class="w-full border rounded p-2">
                @error('password') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mt-4">
                <label class="block font-medium">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="w-full border rounded p-2">
            </div>

            <div class="mt-4">
                <label class="block font-medium">No. HP</label>
                <input type="text" name="no_hp" value="{{ old('no_hp') }}" class="w-full border rounded p-2">
                @error('no_hp') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mt-4">
                <label class="block font-medium">No. Darurat</label>
                <input type="text" name="no_emergency" value="{{ old('no_emergency') }}" class="w-full border rounded p-2">
                @error('no_emergency') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mt-4">
                <label class="block font-medium">Role</label>
                <select name="role" class="w-full border rounded p-2">
                    <option value="">-- Pilih Role --</option>
                    @foreach($roles as $role)
                        <option value="{{ $role }}" {{ old('role') == $role ? 'selected' : '' }}>
                            {{ ucfirst($role) }}
                        </option>
                    @endforeach
                </select>
                @error('role') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mt-4">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Tambah</button>
            </div>
        </form>
    </div>
</x-app-layout>
