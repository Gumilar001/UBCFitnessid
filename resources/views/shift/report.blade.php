<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Transaction</h2>
    </x-slot>

    <div class="container mx-auto p-6">
        <div class="flex items-center justify-between mb-4">
            @auth
                @if(Auth::user()->role === 'admin' || Auth::user()->role === 'staff')
                    <a href="{{ route('pos.index') }}" class="bg-blue-600 hover:bg-blue-800 text-white px-4 py-2 rounded">Tambah Transaction</a>
                @endif
            @endauth

            <form method="GET" action="{{ route('transactions.index') }}" class="flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama/email" class="border rounded p-2">
                
                <select name="shift" class="border rounded p-2 pr-8">
                    <option value="all" {{ request('jenis_pembayaran') === 'all' ? 'selected' : '' }}>Semua Shift</option>
                    @foreach($shifts as $shift)
                        <option value="{{ $shift }}" {{ request('shift') === $shift ? 'selected' : '' }}>
                            {{ ucfirst($shift) }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Filter</button>
            </form>
        </div>

        @if(session('success'))
            <div class="mb-4 text-green-600">{{ session('success') }}</div>
        @endif
        <table class="min-w-full border bg-white rounded shadow">
            <thead>
                <tr class="bg-gray-200">
                    <th class="py-2 px-4 border">Member</th>
                    <th class="py-2 px-4 border">Membership</th>
                    <th class="py-2 px-4 border">Amount</th>
                    <th class="py-2 px-4 border">Payment Method</th>
                    <th class="py-2 px-4 border">Receptionist</th>
                    <th class="py-2 px-4 border">Shifts</th>                    
                    <th class="py-2 px-4 border">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $transaction)
                <tr>
                    <td class="py-2 px-4 border">{{ $transaction->nama }}</td>
                    <td class="py-2 px-4 border text-center">{{ $transaction->membership->name }}</td>
                    <td class="py-2 px-4 border text-center">Rp{{ number_format($transaction->amount,0,',','.') }}</td>
                    <td class="py-2 px-4 border">{{ ucfirst($transaction->jenis_pembayaran) }}</td>
                    <td class="py-2 px-4 border">{{ $transaction->shift->receptionist->name ?? '-' }}</td>
                    <td class="py-2 px-4 border">{{ $transaction->shift->shift ?? '-' }}</td>
                    <td class="py-2 px-4 flex gap-2">
                        <a href="{{ route('transactions.edit', $transaction) }}" class="text-blue-600">Edit</a>
                        <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" onsubmit="return confirm('Delete this transaction?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">Data transaction kosong</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    </script>
    @if(session('success'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                confirmButtonText: 'OK'
            });
        });
    </script>
@endif
</x-app-layout>