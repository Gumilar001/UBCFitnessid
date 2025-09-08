<x-app-layout>
    <div class="max-w-lg mx-auto p-6 bg-white shadow rounded">
        <h1 class="text-xl font-bold mb-4">Manual Check-In</h1>

        <form method="POST" action="{{ route('checkins.store') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium">Pilih Member</label>
                <select name="user_id" class="w-full border rounded p-2">
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->nama }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                Check-In
            </button>
        </form>
    </div>
</x-app-layout>
