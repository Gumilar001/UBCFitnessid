<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Halaman POS</h2>
    </x-slot>
<div class="container mx-auto p-6">
    <h3>POS Dashboard - Shift {{ ucfirst($currentShift->shift_type) }}</h3>
    <p>Mulai: {{ $currentShift->start_time }}</p>
    <hr>
    <h4 class="text-lg font-bold mb-4">Transaksi Baru</h4>
    <form id="posForm" action="{{ route('pos.transaction') }}" method="POST" class="space-y-4 bg-white p-6 rounded-lg shadow-md" enctype="multipart/form-data">
        @csrf
        <div>
        <label for="trans_id" class="text-sm font-medium text-gray-700">Transaction ID</label>
            <input type="text" name="trans_id" id="trans_id" 
                value="{{ $transId }}" readonly 
                class="border p-2 rounded w-full">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1"> Member</label>
            <input type="text" name="nama" list="userList" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Ketik nama member..." required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Produk</label>
            <select id="typeSelect" name="type" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                <option value="">-- Pilih Tipe --</option>
                <option value="membership">Membership</option>
            </select>
        </div>
        <div id="membershipSection" style="display:none;">
            <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Paket Membership</label>
            <select id="membershipSelect" name="membership_id" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <option value="">-- Pilih Paket --</option>
                @foreach(App\Models\Membership::all() as $membership)
                    <option value="{{ $membership->id }}">{{ $membership->name }} ({{ $membership->duration }} hari)</option>
                @endforeach
            </select>
            <!-- Detail Membership -->
            <div id="membershipDetail" class="mt-2 text-sm text-gray-600"></div>

            <!-- Input Email -->
            <div class="mt-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <!-- Input No HP -->
            <div class="mt-4">
                <label for="phone" class="block text-sm font-medium text-gray-700">No HP</label>
                <input type="text" id="phone" name="phone" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <!-- Input Emergency Contact -->
            <div class="mt-4">
                <label for="emergency_contact" class="block text-sm font-medium text-gray-700">No Darurat</label>
                <input type="text" id="emergency_contact" name="emergency_contact" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <!-- Gender -->
             <div class="mt-4">
                <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                <select name="gender" id="gender" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">-- Pilih Gender --</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
             </div>

            <!-- Golongan Darah -->
             <div class="mt-4">
                <label for="golongan_darah" class="block text-sm font-medium text-gray-700">Golongan Darah</label>
                <input type="text" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" name="golongan_darah" id="golongan_darah" placeholder="Contoh: A, B, AB, O">
            </div>

            <!-- Identitas (KTP/SIM) -->
             <div class="mt-4">
                <label for="identitas" class="block text-sm font-medium text-gray-700 mb-2">No Identitas (KTP/SIM)</label>
                <input type="file" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" name="identitas" id="identitas" placeholder="Masukkan No KTP atau SIM" >
            </div>
        </div>
            <div class="mt-4">
                <!-- <label class="block text-sm font-medium text-gray-700">Voucher Kode</label> -->
                <input type="hidden" id="voucher" name="voucher" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Paid At</label>
                <input type="date" name="paid_at" class="w-full border rounded px-3 py-2" required value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" readonly>
            </div>            
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Total</label>
            <input type="number" id="totalInput" name="total" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required readonly>
        </div>
        <button type="submit" class="w-full py-2 px-4 bg-blue-600 text-white font-semibold rounded-md shadow hover:bg-blue-700 transition">Simpan Transaksi</button>
    </form>
    <script>
    let membershipPrice = 0;
    let membershipDiscount = 0;
    let membershipDiscountType = null;

    document.getElementById('typeSelect').addEventListener('change', function() {
        var type = this.value;
        document.getElementById('membershipSection').style.display = (type === 'membership') ? 'block' : 'none';
    });

    document.getElementById('membershipSelect').addEventListener('change', function() {
        var membershipId = this.value;
        if(membershipId) {
            fetch('/pos/membership-detail?membership_id=' + membershipId)
                .then(res => res.json())
                .then(data => {
                    if(data.error) {
                        document.getElementById('membershipDetail').innerHTML = '<span style="color:red">'+data.error+'</span>';
                        document.getElementById('totalInput').value = '';
                    } else {
                        membershipPrice = data.price;
                        membershipDiscount = data.discount ? data.discount.value : 0;
                        membershipDiscountType = data.discount ? data.discount.type : null;
                        let diskonText = '-';
                        let finalPrice = membershipPrice;
                        if(data.discount) {
                            if(data.discount.type === 'percent') {
                                diskonText = data.discount.value + '%';
                                finalPrice = membershipPrice - (membershipPrice * data.discount.value / 100);
                            } else {
                                diskonText = 'Rp ' + Number(data.discount.value).toLocaleString();
                                finalPrice = membershipPrice - data.discount.value;
                            }
                            finalPrice = Math.max(finalPrice, 0);
                        }
                        document.getElementById('membershipDetail').innerHTML =
                            'Harga: Rp ' + Number(membershipPrice).toLocaleString() + '<br>' +
                            'Diskon: ' + diskonText + '<br>' +
                            'Harga Akhir: Rp ' + Number(finalPrice).toLocaleString() + '<br>' +
                            'Durasi: ' + data.duration + ' hari';
                        document.getElementById('totalInput').value = finalPrice;
                    }
                });
        } else {
            document.getElementById('membershipDetail').innerHTML = '';
            document.getElementById('totalInput').value = '';
            membershipPrice = 0;
            membershipDiscount = 0;
            membershipDiscountType = null;
        }
    });

    // Voucher AJAX
    document.getElementById('voucher').addEventListener('blur', function() {
        let voucherCode = this.value;
        let total = parseFloat(document.getElementById('totalInput').value) || 0;
        if(voucherCode && total > 0) {
            fetch('/pos/voucher-detail?voucher=' + voucherCode)
                .then(res => res.json())
                .then(data => {
                    let finalTotal = total;
                    let voucherText = '-';
                    if(data.voucher) {
                        if(data.voucher.type === 'percent') {
                            voucherText = data.voucher.value + '%';
                            finalTotal = finalTotal - (finalTotal * data.voucher.value / 100);
                        } else {
                            voucherText = 'Rp ' + Number(data.voucher.value).toLocaleString();
                            finalTotal = finalTotal - data.voucher.value;
                        }
                        finalTotal = Math.max(finalTotal, 0);
                        document.getElementById('membershipDetail').innerHTML += '<br>Voucher: ' + voucherText + '<br>Total Setelah Voucher: Rp ' + Number(finalTotal).toLocaleString();
                        document.getElementById('totalInput').value = finalTotal;
                    } else if(data.error) {
                        document.getElementById('membershipDetail').innerHTML += '<br><span style="color:red">'+data.error+'</span>';
                    }
                });
        }
    });
    </script>
    </div>
</x-app-layout>