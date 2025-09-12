<x-app-layout>
    <div class="max-w-lg mx-auto bg-white p-6 rounded shadow mt-6">
        <h2 class="text-xl font-bold mb-4">Tambah Diskon</h2>
        <form action="{{ route('discounts.store') }}" method="POST">
            @csrf

            <label class="block">Membership</label>
            <select name="membership_id" class="w-full border rounded p-2 mb-3">
                @foreach($memberships as $membership)
                    <option value="{{ $membership->id }}">{{ $membership->name }}</option>
                @endforeach
            </select>

            <label class="block">Nama Diskon</label>
            <input type="text" name="name" class="w-full border rounded p-2 mb-3">

            <label class="block">Tipe Diskon</label>
            <select name="type" class="w-full border rounded p-2 mb-3">
                <option value="percent">Persen (%)</option>
                <option value="nominal">Nominal (Rp)</option>
            </select>

            <label class="block">Nilai Diskon</label>
            <input type="number" name="value" class="w-full border rounded p-2 mb-3">

            <label class="block">Periode Diskon</label>
            <div class="flex gap-2 mb-3">
                <input type="date" name="start_date" class="w-1/2 border rounded p-2">
                <input type="date" name="end_date" class="w-1/2 border rounded p-2">
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
        </form>
    </div>
</x-app-layout>
