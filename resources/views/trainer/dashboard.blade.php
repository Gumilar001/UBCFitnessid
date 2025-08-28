<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Daftar Booking</h2>
    </x-slot>

    <div class="max-w-6xl mx-auto mt-6">
        <div class="flex items-center justify-between mb-4">
            {{-- Filter hanya untuk Admin --}}
            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'staff')
                <a href="{{ route('booking.create') }}" class="bg-blue-600 hover:bg-blue-800 text-white px-4 py-2 rounded">Tambah Booking PT</a>
                <form method="GET" action="{{ route('trainer.dashboard') }}" class="mb-4 flex gap-2">
                    <select name="user_id" class="form-control">
                        <option value="">-- Semua User --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>

                    <select name="trainer_id" class="form-control">
                        <option value="">-- Semua Trainer --</option>
                        @foreach($trainers as $trainer)
                            <option value="{{ $trainer->id }}" {{ request('trainer_id') == $trainer->id ? 'selected' : '' }}>
                                {{ $trainer->name }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn btn-primary">Filter</button>
                </form>
            @endif
        </div>

        {{-- Tabel Booking --}}
        <table class="w-full mt-4 border">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-2 border">User</th>
                    <th class="p-2 border">Trainer</th>
                    <th class="p-2 border">Jadwal</th>
                    <th class="p-2 border">Catatan</th>
                    <th class="p-2 border">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                    <tr>
                        <td class="p-2 border">{{ $booking->user->name }}</td>
                        <td class="p-2 border">{{ $booking->trainer->name }}</td>
                        <td class="p-2 border">{{ $booking->schedule }}</td>
                        <td class="p-2 border">{{ $booking->notes }}</td>
                        <td class="p-2 border">{{ ucfirst($booking->status) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada booking</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $bookings->links() }}
    </div>
</x-app-layout>
