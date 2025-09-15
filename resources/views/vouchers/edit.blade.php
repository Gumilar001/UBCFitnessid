<x-app-layout>
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-bold mb-4">Edit Voucher</h2>
        <form action="{{ route('vouchers.update', $voucher->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label for="code" class="block text-sm font-medium text-gray-700">Code</label>
                <input type="text" name="code" id="code" value="{{ old('code', $voucher->code) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div>
                <label for="discount" class="block text-sm font-medium text-gray-700">Discount (%)</label>
                <input type="number" name="discount" id="discount" value="{{ old('discount', $voucher->discount) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>
            <div>
                <label for="expiry_date" class="block text-sm font-medium text-gray-700">Expiry Date</label>
                <input type="date" name="expiry_date" id="expiry_date" value="{{ old('expiry_date', $voucher->expiry_date) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update Voucher</button>
        </form>
        </form>
    </div>
</x-app-layout>