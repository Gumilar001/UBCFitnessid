<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Dashboard</h2>
    </x-slot>
<div class="container mx-auto p-6">
    <div class="card shadow-lg p-6 bg-white rounded-lg">
        <h3 class="mb-4">Shift Resepsionis</h3>

        @if ($currentShift)
            <p class="mb-2">Shift saat ini: <b>{{ ucfirst($currentShift->shift_type) }}</b></p>
            <p class="mb-4">Mulai: {{ $currentShift->start_time }}</p>
            <form action="{{ route('shift.close') }}" method="POST">
                @csrf                
            
            <div class="flex flex-nowrap justify-center">
                <div class="p-6 m-4 ">
                    <button type="submit" class="bg-red-600 hover:bg-red-800 text-white px-4 py-2 rounded">Tutup Shift</button>
                </div>                
            </div>
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
</div>
<div class="container mx-auto p-6">
    <div class="flex space-x justify-center">
        <div class="card shadow-lg p-6 bg-white rounded-lg m-4">
            <div class="card-header">
                <h4 class="text-lg font-bold mb-4">Check In Membership</h4>
                <div class="flex flex-nowrap justify-center">                
                    <div class="p-6 m-4 ">
                        <img class="w-full max-w-80 h-full max-h-48" src="{{ asset('images/tap-to-pay.png') }}" alt="">

                        <button class="bg-blue-600 hover:bg-blue-800 text-white px-4 py-2 ml-12 mt-3 rounded">
                            <a href="{{ route('checkins.index') }}" >Check In</a>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="card shadow-lg p-6 bg-white rounded-lg m-4">
            <div class="card-header">
                <h4 class="text-lg font-bold mb-4">Check In Personal Trainer</h4>
                <div class="flex flex-nowrap justify-center">                
                    <div class="p-6 m-4 ">
                        <img class="w-full max-w-80 h-full max-h-48" src="{{ asset('images/tap-to-pay.png') }}" alt="">

                        <button class="bg-green-600 hover:bg-green-800 text-white px-4 py-2 ml-12 mt-3 rounded">
                            <a href="{{ route('checkins.index') }}" >Check In</a>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card shadow-lg p-6 bg-white rounded-lg m-4">
            <div class="card-header">
                <h4 class="text-lg font-bold mb-4">CheckOut Personal Trainer</h4>
                <div class="flex flex-nowrap justify-center">                
                    <div class="p-6 m-4 ">
                        <img class="w-full max-w-80 h-full max-h-48" src="{{ asset('images/tap-to-pay.png') }}" alt="">

                        <button class="bg-red-600 hover:bg-red-800 text-white px-4 py-2 ml-12 mt-3 rounded">
                            <a href="{{ route('checkins.index') }}" >Check Out</a>
                        </button>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
</div>

    
</x-app-layout>