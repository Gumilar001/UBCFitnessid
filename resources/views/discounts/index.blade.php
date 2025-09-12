<x-app-layout>
    <div class="container mx-auto p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Discount List for Membership Packages</h2>
            <div class="flex space-x-2">
                <a href="{{ route('discounts.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Add Discount</a>
                <a href="{{ route('vouchers.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Add Voucher</a>            
            </div>             
        </div>
        @if(session('success'))
            <div class="mb-4 text-green-600">{{ session('success') }}</div>
        @endif
        <table class="min-w-full bg-white rounded shadow">
            <thead>
                <tr class="bg-gray-200">
                    <th class="py-2 px-4 border">Discount Name</th>
                    <th class="py-2 px-4 border">Membership</th>
                    <th class="py-2 px-4 border">Type</th>
                    <th class="py-2 px-4 border">Value</th>
                    <th class="py-2 px-4 border">Start Date</th>
                    <th class="py-2 px-4 border">End Date</th>
                    <th class="py-2 px-4 border">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($discounts as $discount)
                <tr class="text-center">
                    <td class="py-2 px-4 border">{{ $discount->name }}</td>
                    <td class="py-2 px-4 border">{{ $discount->membership->name ?? '-' }}</td>
                    <td class="py-2 px-4 border capitalize">{{ $discount->type }}</td>
                    <td class="py-2 px-4 border">
                        @if($discount->type == 'percent')
                            {{ $discount->value }}%
                        @else
                            Rp{{ number_format($discount->value,0,',','.') }}
                        @endif
                    </td>
                    <td class="py-2 px-4 border">{{ $discount->start_date ?? '-' }}</td>
                    <td class="py-2 px-4 border">{{ $discount->end_date ?? '-' }}</td>
                    <td class="py-2 px-4 border flex gap-2">
                        <a href="{{ route('discounts.edit', $discount) }}" class="text-blue-600">Edit</a>
                        <form action="{{ route('discounts.destroy', $discount) }}" method="POST" onsubmit="return confirm('Delete this discount?')">
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