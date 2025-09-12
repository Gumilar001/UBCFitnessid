<x-app-layout>
<div class="container mx-auto p-6">
    <h2 class="text-xl font-bold mb-4">Pembayaran</h2>

    <div class="bg-white p-6 rounded shadow mb-4">
        <div class="card">
            <div class="card-body">
                <h5>Detail Pesanan</h5>
                <table>
                    <tr>
                        <td>Nama </td>
                        <td>: {{ $transaction->nama }}</td>
                    </tr>
                    <tr>
                        <td>Memberships</td>
                        <td>: {{ $transaction->membership_id }}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>: {{ $transaction->email }}</td>
                    </tr>
                    <tr>
                        <td>No Handphone</td>
                        <td>: {{ $transaction->phone }}</td>
                    </tr>
                    <tr>
                        <td>Emergency Contact</td>
                        <td>: {{ $transaction->emergency_contact }}</td>
                    </tr>
                    <tr>
                        <td>Total Bayar</td>
                        <td>: Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                    </tr>
                </table>
                <button id="pay-button" class="bg-blue-600 text-white px-4 py-2 rounded">
                    Bayar Sekarang
                </button>
            </div>
        </div>
    </div>


    
</div>
<!-- Midtrans Snap JS -->
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
