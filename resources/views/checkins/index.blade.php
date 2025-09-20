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
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Check-in Member</h2>
    </x-slot>

    <div class="container px-6 mx-auto space-y-6 mt-5">    
        <form id="rfid_form" action="{{ route('checkins.store') }}" method="POST">
            @csrf
            <input type="text" name="rfid_code" value="{{ $uid }}" readonly class="border px-4 py-2">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Check-in</button>
        </form>

        <div id="statusMessage" class="mt-4 font-semibold"></div>
    </div>

    <!-- List checkin -->
    <div class="container mx-auto p-6 bg-white shadow rounded-lg">
        <table class="min-w-full border">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2 border">Nama</th>
                    <th class="px-4 py-2 border">Membership</th>
                    <th class="px-4 py-2 border">UID</th>
                    <th class="px-4 py-2 border">Waktu Check-in</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @foreach($checkins as $c)
                    <tr>
                        <td class="border px-4 py-2">{{ $c->user->name }}</td>
                        <td class="border px-4 py-2">{{ $c->user->userMemberships->membership->name ?? '-' }}</td>
                        <td class="border px-4 py-2">{{ $c->user->userMemberships->rfid_code ?? '-' }}</td>
                        <td class="border px-4 py-2">{{ $c->checkin_time }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script>
setInterval(() => {
    window.location.reload();
}, 3000); 
</script>

</x-app-layout>
