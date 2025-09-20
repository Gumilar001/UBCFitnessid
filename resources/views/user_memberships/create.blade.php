@php
    $uid_file = public_path('uid.txt'); // file disimpan di folder public/
    $uid = "-";
    if (file_exists($uid_file)) {
        $uid = trim(file_get_contents($uid_file));
        if ($uid === "") {
            $uid = "-";
        }
    }
@endphp

<x-app-layout>
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-bold mb-4">Add User Membership</h2>
        <form action="{{ route('user-memberships.store') }}" method="POST" class="space-y-4">
            @csrf

            {{-- Pilih User --}}
            <div>
                <label class="block">User</label>
                <select name="user_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">-- Select User --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Pilih Membership --}}
            <div>
                <label class="block">Membership</label>
                <select id="membership_id" name="membership_id" class="w-full border rounded px-3 py-2" onchange="setDates(this)" required>
                    <option value="">-- Select Membership --</option>
                    @foreach($memberships as $membership)
                        <option value="{{ $membership->id }}" data-duration="{{ $membership->duration }}">
                            {{ $membership->name }} ({{ $membership->duration }} hari)
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- RFID Code --}}
            <div>
                <label class="block">RFID Code</label>
                <input type="text" name="rfid_code" value="{{ $uid }}" class="w-full border rounded px-3 py-2" required>
            </div>

            {{-- Start Date --}}
            <div>
                <label class="block">Start Date</label>
                <input type="date" id="start_date" name="start_date" class="w-full border rounded px-3 py-2" readonly>
            </div>

            {{-- End Date --}}
            <div>
                <label class="block">End Date</label>
                <input type="date" id="end_date" name="end_date" class="w-full border rounded px-3 py-2" readonly>
            </div>

            {{-- Status --}}
            <div>
                <label class="block">Status</label>
                <select name="status" class="w-full border rounded px-3 py-2" required>
                    <option value="active">Active</option>
                    <option value="expired">Expired</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>

            {{-- Tombol --}}
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
            <a href="{{ route('user-memberships.index') }}" class="ml-2 text-gray-600">Cancel</a>
        </form>
    </div>

    <script>
        function setDates(select) {
            let duration = parseInt(select.options[select.selectedIndex].getAttribute('data-duration')) || 0;

            if (duration > 0) {
                let today = new Date();

                // Start Date = hari ini
                let startDate = today.toISOString().split('T')[0];
                document.getElementById('start_date').value = startDate;

                // End Date = hari ini + duration
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
