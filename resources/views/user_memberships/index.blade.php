<x-app-layout>
    <div class="container mx-auto p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">User Membership List</h2>
            <a href="{{ route('user-memberships.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Add User Membership</a>
        </div>
        @if(session('success'))
            <div class="mb-4 text-green-600">{{ session('success') }}</div>
        @endif
        <table class="min-w-full bg-white rounded shadow">
            <thead>
                <tr>
                    <th class="py-2 px-4">User</th>
                    <th class="py-2 px-4">Membership</th>
                    <th class="py-2 px-4">Start Date</th>
                    <th class="py-2 px-4">End Date</th>
                    <th class="py-2 px-4">Status</th>
                    <th class="py-2 px-4">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($userMemberships as $um)
                <tr>
                    <td class="py-2 px-4">{{ $um->user->name }}</td>
                    <td class="py-2 px-4">{{ $um->membership->name }}</td>
                    <td class="py-2 px-4">{{ $um->start_date }}</td>
                    <td class="py-2 px-4">{{ $um->end_date }}</td>
                    <td class="py-2 px-4">{{ ucfirst($um->status) }}</td>
                    <td class="py-2 px-4 flex gap-2">
                        <a href="{{ route('user-memberships.edit', $um) }}" class="text-blue-600">Edit</a>
                        <a href="{{ route('user-memberships.print', $um->id) }}" target="_blank" class="text-green-600">
                            Cetak
                        </a>
                        <form action="{{ route('user-memberships.destroy', $um) }}" method="POST" onsubmit="return confirm('Delete this user membership?')">
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