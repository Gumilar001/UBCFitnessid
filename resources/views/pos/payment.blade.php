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
                        <td>: {{ $transaction->membership->name }}</td>
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
<script type="text/javascript"
    src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('midtrans.client_key') }}">
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">
    document.getElementById('pay-button').onclick = function () {
        snap.pay('{{ $snapToken }}', {
            onSuccess: function(result){
                console.log(result);
                Swal.fire({
                    icon: 'success',
                    title: 'Pembayaran Berhasil',
                    text: 'Terima kasih, transaksi kamu sukses!',
                    confirmButtonText: 'OK'
                });
            },
            onPending: function(result){
                console.log(result);
                Swal.fire({
                    icon: 'info',
                    title: 'Menunggu Pembayaran',
                    text: 'Transaksi kamu masih pending. Selesaikan pembayaran dulu.',
                    confirmButtonText: 'OK'
                });
            },
            onError: function(result){
                console.log(result);
                Swal.fire({
                    icon: 'error',
                    title: 'Pembayaran Gagal',
                    text: 'Silakan coba lagi atau gunakan metode lain.',
                    confirmButtonText: 'OK'
                });
            },
            onClose: function(){
                Swal.fire({
                    icon: 'warning',
                    title: 'Popup Ditutup',
                    text: 'Kamu menutup jendela pembayaran sebelum selesai.',
                    confirmButtonText: 'Mengerti'
                });
            }
        });
    };
</script>
</x-app-layout>
