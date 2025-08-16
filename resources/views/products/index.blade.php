<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Daftar Produk
        </h2>
    </x-slot>

    <div class="p-6 bg-white dark:bg-gray-800 shadow rounded-lg">
        <a href="{{ route('products.create') }}"
           class="mb-4 inline-block bg-blue-600 text-white px-4 py-2 rounded">
           + Tambah Produk
        </a>
        <div class="py-6">
            @if(session('success'))
                <div class="mb-4 text-green-600 dark:text-green-400">
                    {{ session('success') }}
                </div>
            @endif

            @if($products->isEmpty())
                <p class="text-gray-500 dark:text-gray-400">Tidak ada produk yang tersedia.</p>
            @endif
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <div class="bg-gray-900 border border-gray-700 rounded-lg overflow-hidden shadow hover:shadow-lg transition">
                        {{-- Gambar produk --}}
                        <img src="{{ asset('storage/' . $product->foto) }}"
                             alt="{{ $product->name }}"
                             class="w-full h-48 object-cover">

                        {{-- Isi card --}}
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-semibold text-white">{{ $product->name }}</h3>
                            <p class="text-gray-400 text-sm mb-2">Rp {{ number_format($product->price, 0, ',', '.') }}</p>

                            {{-- Tombol aksi --}}
                            <div class="flex justify-center gap-4 mt-3">
                                <a href="{{ route('products.show', $product->id) }}"
                                   class="p-2 rounded-full border border-gray-600 text-gray-300 hover:bg-gray-700">
                                    👁️
                                </a>
                                <form action="{{ route('transactions.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button type="submit"
                                            class="p-2 rounded-full border border-gray-600 text-gray-300 hover:bg-gray-700">
                                        🛒
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
