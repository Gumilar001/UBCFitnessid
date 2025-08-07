<x-app-layout>
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-bold mb-4">Edit Membership</h2>
        <form action="{{ route('memberships.update', $membership) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block">Name</label>
                <input type="text" name="name" value="{{ $membership->name }}" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block">Duration (days)</label>
                <input type="number" name="duration" value="{{ $membership->duration }}" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block">Price</label>
                <input type="number" name="price" value="{{ $membership->price }}" class="w-full border rounded px-3 py-2" required>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
            <a href="{{ route('memberships.index') }}" class="ml-2 text-gray-600">Cancel</a>
        </form>
    </div>
</x-app-layout>