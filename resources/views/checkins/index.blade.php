<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Check-in Member</h2>
    </x-slot>

    <div class="container px-6 mx-auto space-y-6 mt-5">    

        <label class="font-semibold text-l" for="rfid_code">Scan RFID</label>
        <input type="text" id="rfid_code" name="rfid_code"
            autofocus
            autocomplete="off"
            class="border rounded p-2 w-full"
            placeholder="Tempelkan kartu RFID" />

        <div id="statusMessage" class="mt-4 font-semibold"></div>
    </div>

<!-- List checkin -->
        <div class="container mx-auto p-6 bg-white shadow rounded-lg">
            <table class="min-w-full border">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-2 border">Nama</th>
                        <th class="px-4 py-2 border">Membership</th>
                        <th class="px-4 py-2 border">Waktu Check-in</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($checkins as $c)
                        <tr>
                            <td class="border px-4 py-2">{{ $c->user->name }}</td>
                            <td class="border px-4 py-2">{{ $c->user->userMemberships->first()->membership->name ?? '-' }}</td>
                            <td class="border px-4 py-2">{{ $c->checkin_time }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const rfidInput = document.getElementById("rfid_code");
        const statusDiv = document.getElementById("statusMessage");

        rfidInput.addEventListener("keypress", function (e) {
            if (e.key === "Enter") {
                e.preventDefault();

                let rfidCode = rfidInput.value.trim();
                if (!rfidCode) return;

                // Kirim via AJAX (fetch API)
                fetch("{{ route('checkins.store') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ rfid_code: rfidCode })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        statusDiv.innerHTML = "✅ " + data.message;
                        statusDiv.classList.add("text-green-600");
                        statusDiv.classList.remove("text-red-600");
                    } else {
                        statusDiv.innerHTML = "❌ " + data.message;
                        statusDiv.classList.add("text-red-600");
                        statusDiv.classList.remove("text-green-600");
                    }
                    rfidInput.value = ""; // reset input
                    rfidInput.focus();
                })
                .catch(err => {
                    console.error(err);
                    statusDiv.innerHTML = "⚠️ Terjadi error koneksi.";
                    statusDiv.classList.add("text-red-600");
                    rfidInput.value = "";
                    rfidInput.focus();
                });
            }
        });
    });
</script>
</x-app-layout>
