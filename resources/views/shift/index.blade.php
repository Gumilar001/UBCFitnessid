<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Halaman Shift</h2>
    </x-slot>
<div class="container mx-auto p-6">
    <h3>Shift Resepsionis</h3>

    @if ($currentShift)
        <p>Shift saat ini: <b>{{ ucfirst($currentShift->shift_type) }}</b></p>
        <p>Mulai: {{ $currentShift->start_time }}</p>
        <form action="{{ route('shift.close') }}" method="POST">
            @csrf
            <button type="submit" class="bg-red-600 hover:bg-red-800 text-white px-4 py-2 rounded">Tutup Shift</button>
            <a href="{{ route('pos.index') }}"  class="bg-blue-600 hover:bg-blue-800 text-white px-4 py-2 rounded">Pemesanan</a>
        </form>
    @else
        <form action="{{ route('shift.open') }}" method="POST">
            @csrf
            <label>Pilih Shift:</label>
            <select name="shift_type" class="form-control">
                <option value="pagi">Pagi</option>
                <option value="sore">Sore</option>
            </select>
            <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white px-4 py-2 rounded">Buka Shift</button>            
        </form>
    @endif
</div>
</x-app-layout>