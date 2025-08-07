<x-app-layout>
    <div class="container mx-auto p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Membership List</h2>
            <a href="{{ route('memberships.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Add Membership</a>
        </div>
        @if(session('success'))
            <div class="mb-4 text-green-600">{{ session('success') }}</div>
        @endif
        <table class="min-w-full bg-white rounded shadow">
            <thead>
                <tr>
                    <th class="py-2 px-4">Name</th>
                    <th class="py-2 px-4">Duration</th>
                    <th class="py-2 px-4">Price</th>
                    <th class="py-2 px-4">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($memberships as $membership)
                <tr>
                    <td class="py-2 px-4">{{ $membership->name }}</td>
                    <td class="py-2 px-4">{{ $membership->duration }} days</td>
                    <td class="py-2 px-4">Rp{{ number_format($membership->price,0,',','.') }}</td>
                    <td class="py-2 px-4 flex gap-2">
                        <a href="{{ route('memberships.edit', $membership) }}" class="text-blue-600">Edit</a>
                        <form action="{{ route('memberships.destroy', $membership) }}" method="POST" onsubmit="return confirm('Delete this membership?')">
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