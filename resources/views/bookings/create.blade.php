<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Booking Personal Trainer </h2>
    </x-slot>

<div class="max-w-2xl mx-auto p-6 bg-white shadow-md rounded-lg mt-3">
        <form action="{{ route('booking.store') }}" method="POST">
            @csrf

            @if(auth()->user()->role === 'admin')
            <div class="mt-4">
                <label class="block">Member</label>
                <select name="user_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">-- Select Member --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                @error('user_id') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            @endif

            <div class="mt-4">
                <label class="block font-medium">Trainer</label>
                <select name="trainer_id" class="w-full border rounded p-2">
                    <option value="">-- Pilih Trainer --</option>
                     @foreach($trainers as $trainer)
                    <option value="{{ $trainer->id }}">{{ $trainer->name }}</option>
                @endforeach
                </select>
                @error('trainer_id') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mt-4">
                <label class="block font-medium">Schedule</label>
                <input type="datetime-local" name="schedule" value="{{ old('schedule') }}" class="w-full border rounded p-2">
                @error('schedule') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mt-4">
                <label class="block font-medium">Catatan </label>
                <input type="notes" placeholder="Opsional" name="notes" value="{{ old('notes') }}" class="w-full border rounded p-2">
                @error('notes') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="mt-4">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Tambah</button>
            </div>
        </form>
    </div>
</x-app-layout>