<x-app-layout>
    <div class="container mx-auto p-6">
        <div class="card p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4">Add Membership</h2>
        <form action="{{ route('memberships.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block">Nama Membership</label>
                <input type="text" name="name" placeholder="Masukan Nama Membership" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block">Duration (days)</label>
                <input type="number" name="duration" placeholder="Masukan Durasi" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block">Price</label>
                <input type="number" name="price" placeholder="Masukan Harga Membership" class="w-full border rounded px-3 py-2" required>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
            <a href="{{ route('memberships.index') }}" class="ml-2 text-gray-600">Cancel</a>
        </form>
        </div>
    </div>
</x-app-layout>