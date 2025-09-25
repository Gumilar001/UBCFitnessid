<x-app-layout>
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-bold mb-4">Edit Discount</h2>
        <form action="{{ route('discounts.update', $discount->id) }}" method="POST" class="bg-white p-6 rounded shadow-md">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="membership" class="block text-gray-700 font-bold mb-2">Membership</label>
                <select name="membership_id" id="membership" class="w-full border rounded px-3 py-2" required>
                    <option value="">-- Select Membership --</option>
                    @foreach($memberships as $membership)
                        <option value="{{ $membership->id }}" {{ (old('membership_id', $discount->membership_id) == $membership->id) ? 'selected' : '' }}>
                            {{ $membership->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-bold mb-2">Discount Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $discount->name) }}" class="w-full border rounded px-3 py-2" required>
                @error('name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="type" class="block text-gray-700 font-bold mb-2">Discount Type</label>
                <select name="type" id="type" class="w-full border rounded px-3 py-2" required>
                    <option value="percent" {{ old('type', $discount->type) == 'percent' ? 'selected' : '' }}>Percent</option>
                    <option value="nominal" {{ old('type', $discount->type) == 'nominal' ? 'selected' : '' }}>Nominal</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="value" class="block text-gray-700 font-bold mb-2">Percentage (%)</label>
                <input type="number" name="value" id="value" value="{{ old('value', $discount->value) }}" class="w-full border rounded px-3 py-2" min="0" max="100" required>
                @error('value')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="start_date">Start Date</label>
                <input type="date" name="start_date" id="start_date" value="{{ \Carbon\Carbon::parse($discount->start_date)->format('Y-m-d') }}" class="w-full border rounded px-3 py-2" required>                
            </div>
            <div class="mb-4">
                <label for="end_date">End Date</label>
                <input type="date" name="end_date" id="end_date" value="{{ \Carbon\Carbon::parse($discount->end_date)->format('Y-m-d') }}" class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('discounts.index') }}" class="mr-4 bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Cancel</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update Discount</button>
            </div>
        </form>
    </div>
</x-app-layout>