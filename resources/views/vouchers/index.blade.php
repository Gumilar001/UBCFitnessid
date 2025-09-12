<x-app-layout>
    <div class="container mx-auto p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Voucher List </h2>
            <a href="{{ route('vouchers.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Add Voucher</a>
        </div>
        @if(session('success'))
            <div class="mb-4 text-green-600">{{ session('success') }}</div>
        @endif
        <table class="min-w-full bg-white rounded shadow">
            <thead>
                <tr class="bg-gray-200">
                    <th class="py-2 px-4 border">Code</th>
                    <th class="py-2 px-4 border">Type</th>
                    <th class="py-2 px-4 border">Value</th>
                    <th class="py-2 px-4 border">Start Date</th>
                    <th class="py-2 px-4 border">End Date</th>
                    <th class="py-2 px-4 border">Usage Limit</th>
                    <th class="py-2 px-4 border">Used</th>
                    <th class="py-2 px-4 border">Status</th>
                    <th class="py-2 px-4 border">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vouchers as $voucher)
                <tr class="text-center">
                    <td class="py-2 px-4 border">{{ $voucher->code }}</td>
                    <td class="py-2 px-4 border capitalize">{{ $voucher->type }}</td>
                    <td class="py-2 px-4 border">
                        @if($voucher->type == 'percent')
                            {{ $voucher->value }}%
                        @else
                            Rp{{ number_format($voucher->value,0,',','.') }}
                        @endif
                    </td>
                    <td class="py-2 px-4 border">{{ $voucher->start_date ?? '-' }}</td>
                    <td class="py-2 px-4 border">{{ $voucher->end_date ?? '-' }}</td>
                    <td class="py-2 px-4 border">{{ $voucher->usage_limit ?? 'Unlimited' }}</td>
                    <td class="py-2 px-4 border">{{ $voucher->used }}</td>
                    <td class="py-2 px-4 border">{{ ucfirst($voucher->status) }}</td>
                    <td class="py-2 px-4 border flex gap-2">
                        <a href="{{ route('vouchers.edit', $voucher) }}" class="text-blue-600">Edit</a>
                        <form action="{{ route('vouchers.destroy', $voucher) }}" method="POST" onsubmit="return confirm('Delete this voucher?')">
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
</x-app-layout>