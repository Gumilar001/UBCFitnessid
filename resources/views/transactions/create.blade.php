<x-app-layout>
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-bold mb-4">Add Transaction</h2>
        <form action="{{ route('transactions.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block">Member</label>
                <select name="user_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">-- Select Member --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block">Membership</label>
                <select name="membership_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">-- Select Membership --</option>
                    @foreach($memberships as $membership)
                        <option value="{{ $membership->id }}">{{ $membership->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block">Amount</label>
                <input type="number" name="amount" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block">Paid At</label>
                <input type="date" name="paid_at" class="w-full border rounded px-3 py-2" required>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
            <a href="{{ route('transactions.index') }}" class="ml-2 text-gray-600">Cancel</a>
        </form>
    </div>
</x-app-layout>