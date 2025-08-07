<x-app-layout>
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-bold mb-4">Edit User Membership</h2>
        <form action="{{ route('user-memberships.update', $userMembership) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block">User</label>
                <select name="user_id" class="w-full border rounded px-3 py-2" required>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $userMembership->user_id == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block">Membership</label>
                <select name="membership_id" class="w-full border rounded px-3 py-2" required>
                    @foreach($memberships as $membership)
                        <option value="{{ $membership->id }}" {{ $userMembership->membership_id == $membership->id ? 'selected' : '' }}>
                            {{ $membership->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block">Start Date</label>
                <input type="date" name="start_date" value="{{ $userMembership->start_date }}" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block">End Date</label>
                <input type="date" name="end_date" value="{{ $userMembership->end_date }}" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block">Status</label>
                <select name="status" class="w-full border rounded px-3 py-2 mb-2" required>
                    <option value="active" {{ $userMembership->status == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $userMembership->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
            <a href="{{ route('user-memberships.index') }}" class="ml-2 text-gray-600">Cancel</a>
        </form>
    </div>
</x-app-layout>