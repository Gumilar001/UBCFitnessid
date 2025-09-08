<x-app-layout>
    <div class="container mx-auto p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Transaction List</h2>
            <a href="{{ route('pos.index') }}" class="bg-blue-600 hover:bg-blue-800 text-white px-4 py-2 rounded">Add Transaction</a>
        </div>
        @if(session('success'))
            <div class="mb-4 text-green-600">{{ session('success') }}</div>
        @endif
        <table class="min-w-full bg-white rounded shadow">
            <thead>
                <tr>
                    <th class="py-2 px-4">Member</th>
                    <th class="py-2 px-4">Membership</th>
                    <th class="py-2 px-4">Email</th>
                    <th class="py-2 px-4">Phone</th>
                    <th class="py-2 px-4">Emergency Contact</th>
                    <th class="py-2 px-4">Amount</th>
                    <th class="py-2 px-4">Payment Method</th>
                    <th class="py-2 px-4">Receptionist</th>
                    <th class="py-2 px-4">Paid At</th>
                    <th class="py-2 px-4">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $transaction)
                <tr>
                    <td class="py-2 px-4">{{ $transaction->nama }}</td>
                    <td class="py-2 px-4">{{ $transaction->membership->name }}</td>
                    <td class="py-2 px-4">{{ $transaction->email ?? '-' }}</td>
                    <td class="py-2 px-4">{{ $transaction->phone ?? '-' }}</td>
                    <td class="py-2 px-4">{{ $transaction->emergency_contact ?? '-' }}</td>
                    <td class="py-2 px-4">Rp{{ number_format($transaction->amount,0,',','.') }}</td>
                    <td class="py-2 px-4">{{ ucfirst($transaction->jenis_pembayaran) }}</td>
                    <td class="py-2 px-4">{{ $transaction->shift->receptionist->name ?? '-' }}</td>
                    <td class="py-2 px-4">{{ $transaction->paid_at }}</td>
                    <td class="py-2 px-4 flex gap-2">
                        <a href="{{ route('transactions.edit', $transaction) }}" class="text-blue-600">Edit</a>
                        <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" onsubmit="return confirm('Delete this transaction?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
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