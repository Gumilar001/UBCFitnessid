<x-app-layout>
<div class="container mx-auto p-6">
    <h2 class="text-xl font-bold mb-4">Pembayaran</h2>

    <button id="pay-button" class="bg-blue-600 text-white px-4 py-2 rounded">
        Bayar Sekarang
    </button>
</div>

<!-- Midtrans JS -->
<script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
document.getElementById('pay-button').onclick = function() {
    snap.pay('{{ $snapToken }}', {
        onSuccess: function(result){ window.location.href = "{{ route('transactions.index') }}"; },
        onPending: function(result){ window.location.href = "{{ route('transactions.index') }}"; },
        onError: function(result){ alert('Pembayaran gagal!'); }
    });
};
</script>
</x-app-layout>
