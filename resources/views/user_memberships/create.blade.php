<x-app-layout>
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-bold mb-4">Add User Membership</h2>
        <form action="{{ route('user-memberships.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block">User</label>
                <select name="user_id" class="w-full border rounded px-3 py-2" onchange="setMembership(this)" required>
                    <option value="">-- Select User --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}"
                            data-membership="{{ $user->latestTransaction?->membership?->name ?? 'Belum Ada' }}"
                            data-membership-id="{{ $user->latestTransaction?->membership?->id ?? '' }}"
                            data-duration="{{ $user->latestTransaction?->membership?->duration ?? 0 }}">
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>

            </div>
            <div>
                <label class="block">Membership</label>
                <input type="hidden" id="membership_id" name="membership_id">
                <input type="text" id="membership" name="membership" class="w-full border rounded px-3 py-2" readonly>
            </div>
            <div>
                <label class="block">Start Date</label>
                <input type="date" id="start_date" name="start_date" class="w-full border rounded px-3 py-2" readonly>
            </div>
            <div>
                <label class="block">End Date</label>
                <input type="date" id="end_date" name="end_date" class="w-full border rounded px-3 py-2" readonly>
            </div>
            <div>
                <label class="block">Status</label>
                <select name="status" class="w-full border rounded px-3 py-2" required>
                    <option value="active">Active</option>
                    <option value="expired">Expired</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
            <a href="{{ route('user-memberships.index') }}" class="ml-2 text-gray-600">Cancel</a>
        </form>
    </div>

    <script>
        function setMembership(select) {
            let membership = select.options[select.selectedIndex].getAttribute('data-membership');
            let membershipId = select.options[select.selectedIndex].getAttribute('data-membership-id');
            let duration = parseInt(select.options[select.selectedIndex].getAttribute('data-duration')) || 0;

            document.getElementById('membership').value = membership;
            document.getElementById('membership_id').value = membershipId;

            if (duration > 0) {
                let today = new Date();

                // Start Date = hari ini
                let startDate = today.toISOString().split('T')[0];
                document.getElementById('start_date').value = startDate;

                // End Date = hari ini + duration (misal 30 hari)
                let endDate = new Date();
                endDate.setDate(today.getDate() + duration);
                document.getElementById('end_date').value = endDate.toISOString().split('T')[0];
            } else {
                document.getElementById('start_date').value = '';
                document.getElementById('end_date').value = '';
            }
        }
    </script>
</x-app-layout>
