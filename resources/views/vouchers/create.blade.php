<x-app-layout>
    <div class="max-w-xl mx-auto p-6 mt-6 bg-white shadow rounded">
        <h2 class="text-xl font-bold mb-4">Tambah Voucher Baru</h2>

        @if(session('success'))
            <div class="p-3 bg-green-100 text-green-800 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('vouchers.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block font-medium">Kode Voucher</label>
                <input type="text" name="code" class="w-full border rounded px-3 py-2" required>
                @error('code') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block font-medium">Jenis Diskon</label>
                <select name="type" class="w-full border rounded px-3 py-2" required>
                    <option value="percent">Percent (%)</option>
                    <option value="fixed">Fixed (Rp)</option>
                </select>
            </div>

            <div>
                <label class="block font-medium">Nilai Diskon</label>
                <input type="number" name="value" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block font-medium">Tanggal Mulai</label>
                <input type="date" name="start_date" class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block font-medium">Tanggal Berakhir</label>
                <input type="date" name="end_date" class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block font-medium">Batas Penggunaan (0 = unlimited)</label>
                <input type="number" name="usage_limit" class="w-full border rounded px-3 py-2" value="0">
            </div>

            <div class="class">
                <label for="" class="block font-medium">Status Voucher</label>
                <select name="status" class="w-full border rounded px-3 py-2" required>
                    <option value="active">Active</option>
                    <option value="expired">Expired</option>
                </select>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
            <a href="{{ route('vouchers.index') }}" class="ml-2 text-gray-600">Batal</a>

        </form>
    </div>
</x-app-layout>
