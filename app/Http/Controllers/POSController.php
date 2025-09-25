<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Transaction;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Membership;
use App\Models\Discount; 
use App\Models\Voucher; 
use Midtrans\Snap;
use Midtrans\Notification;
use Midtrans\Config;



class POSController extends Controller
{
    public function __construct()
    {
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$clientKey = config('midtrans.client_key');
    }

    public function storeTransaction(Request $request)
    {
        $request->validate([
            'trans_id' => 'required|string|unique:transactions,trans_id',
            'nama' => 'required|string|max:255',
            'type' => 'required|string',
            'membership_id' => 'nullable|numeric|exists:memberships,id',
            'total' => 'required|numeric',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'emergency_contact' => 'nullable|string|max:20',
            'gender' => 'nullable|string|max:10',
            'golongan_darah' => 'nullable|string|max:5',
            'identitas' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096',
            'voucher' => 'nullable|string',
        ]);

        $currentShift = Shift::where('receptionist_id', auth()->id())
            ->whereNull('end_time')
            ->first();
        if (!$currentShift) {
            return redirect()->route('shift.index')->with('error', 'Silakan buka shift dulu.');
        }

        
        $identitasPath = null;

        if ($request->hasFile('identitas')) {
            $file = $request->file('identitas');
            $filename = time().'_'.$file->getClientOriginalName();
            $path = $file->storeAs('identitas-membership', $filename, 'public');
            $identitasPath = $path;
        }

        
        // Membership logic
        $membershipId = $request->membership_id;
        if (!$membershipId) {
            $visitMembership = Membership::where('name', 'VISIT')->first();
            if ($visitMembership) {
                $membershipId = $visitMembership->id;
            }
        } 

        if ($request->type === 'membership') {
            $user = User::where('email', $request->email)->first();
            if (!$user && $request->email) {
                $user = User::create([
                    'name' => $request->nama,
                    'email' => $request->email,
                    'password' => Hash::make('12345678'),
                    'no_hp' => $request->phone,
                    'no_emergency' => $request->emergency_contact,
                    'gender' => $request->gender,
                    'golongan_darah' => $request->golongan_darah,
                    'role' => 'user',
                ]);
            }
        }

        // Diskon membership
        $membership = Membership::find($membershipId);
        $discount = Discount::where('membership_id', $membershipId)
            ->where(function($q){
                $q->whereNull('start_date')->orWhere('start_date', '<=', now());
            })
            ->where(function($q){
                $q->whereNull('end_date')->orWhere('end_date', '>=', now());
            })
            ->first();

        $total = $membership ? $membership->price : $request->total;
        if ($discount) {
            if ($discount->type == 'percent') {
                $total = $total - ($total * $discount->value / 100);
            } else {
                $total = $total - $discount->value;
            }
            $total = max($total, 0);
        }

        // Diskon voucher
        $voucherCode = $request->voucher;
        $voucher = null;
        if ($voucherCode) {
            $voucher = Voucher::where('code', $voucherCode)
                ->where(function($q){
                    $q->whereNull('start_date')->orWhere('start_date', '<=', now());
                })
                ->where(function($q){
                    $q->whereNull('end_date')->orWhere('end_date', '>=', now());
                })
                ->where('is_active', true)
                ->first();

            if ($voucher) {
                if ($voucher->type == 'percent') {
                    $total = $total - ($total * $voucher->value / 100);
                } else {
                    $total = $total - $voucher->value;
                }
                $total = max($total, 0);
            }
        }


        $transaction = Transaction::create([
            'trans_id' => $request->trans_id,
            'nama' => $request->nama,
            'membership_id' => $membershipId,
            'email' => $request->email,
            'phone' => $request->phone,
            'emergency_contact' => $request->emergency_contact,
            'gender' => $request->gender,
            'golongan_darah' => $request->golongan_darah,
            'identitas' => $identitasPath,
            'amount' => $request->total,
            'jenis_pembayaran' => null,
            'status' => 'pending',
            'paid_at' => now(),
            'shift_id' => $currentShift->id,
            'voucher_code' => $voucherCode, // simpan kode voucher jika ada
        ]);

     // Redirect ke halaman pembayaran
    return redirect()->route('pos.payment', ['transactionId' => $request->trans_id]);
    }

    // Endpoint AJAX untuk ambil detail membership
    public function getMembershipDetail(Request $request)
    {
        $membership = \App\Models\Membership::find($request->membership_id);
        if (!$membership) {
            return response()->json(['error' => 'Membership tidak ditemukan'], 404);
        }
        $discount = \App\Models\Discount::where('membership_id', $membership->id)
            ->where(function($q){
                $q->whereNull('start_date')->orWhere('start_date', '<=', now());
            })
            ->where(function($q){
                $q->whereNull('end_date')->orWhere('end_date', '>=', now());
            })
            ->first();

        $finalPrice = $membership->price;
        $discountData = null;
        if($discount) {
            if($discount->type == 'percent') {
                $finalPrice = $membership->price - ($membership->price * $discount->value / 100);
            } else {
                $finalPrice = $membership->price - $discount->value;
            }
            $finalPrice = max($finalPrice, 0);
            $discountData = [
                'type' => $discount->type,
                'value' => $discount->value,
                'name' => $discount->name,
            ];
        }

        return response()->json([
            'price' => $membership->price,
            'discount' => $discountData,
            'final_price' => $finalPrice,
            'name' => $membership->name,
            'duration' => $membership->duration
        ]);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transaction) {
            if (empty($transaction->trans_id)) {
                $transaction->trans_id = 'TRX-' . mt_rand(1000, 9999);
            }
        });
    }


    public function index()
    {
        $transId = 'TRX-' . date('ymd') . '-' . mt_rand(1000, 9999);
        $memberships = Membership::all();

        // Ambil diskon aktif untuk setiap membership
        $today = now()->toDateString();
        $discounts = Discount::where(function($q) use ($today) {
            $q->whereNull('start_date')->orWhere('start_date', '<=', $today);
        })->where(function($q) use ($today) {
            $q->whereNull('end_date')->orWhere('end_date', '>=', $today);
        })->get()->groupBy('membership_id');

        $currentShift = Shift::where('receptionist_id', auth()->id())
            ->whereNull('end_time')
            ->first();

        if (!$currentShift) {
            return redirect()->route('shift.index')->with('error', 'Silakan buka shift dulu.');
        }

        return view('pos.index', compact('currentShift', 'memberships', 'transId', 'discounts'));
    }

    public function storeMember(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'membership_type' => 'required|string',
            'price'    => 'required|numeric',
        ]);

        $currentShift = Shift::where('receptionist_id', auth()->id())
            ->whereNull('end_time')
            ->first();

        if (!$currentShift) {
            return redirect()->route('shift.index')->with('error', 'Silakan buka shift dulu.');
        }

        // buat user baru (role = user)
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'user',
        ]);

        // buat transaksi membership
        Transaction::create([
            'user_id'  => $user->id,
            'shift_id' => $currentShift->id,
            'type'     => 'membership',
            'total'    => $request->price,
            'details'  => json_encode(['membership_type' => $request->membership_type]),
        ]);

        return redirect()->route('pos.index')->with('success', 'Member baru berhasil ditambahkan.');
    }

    // Endpoint AJAX untuk ambil detail voucher
    public function getVoucherDetail(Request $request)
    {
        $voucherCode = $request->voucher;
        $voucher = \App\Models\Voucher::where('code', $voucherCode)
            ->where(function($q){
                $q->whereNull('start_date')->orWhere('start_date', '<=', now());
            })
            ->where(function($q){
                $q->whereNull('end_date')->orWhere('end_date', '>=', now());
            })
            ->where('is_active', true)
            ->first();

        if (!$voucher) {
            return response()->json(['error' => 'Voucher tidak valid atau sudah kadaluarsa']);
        }

        return response()->json([
            'voucher' => [
                'type' => $voucher->type,
                'value' => $voucher->value,
                'name' => $voucher->name ?? '',
            ]
        ]);
    }

    public function payment($transactionId)
    {
        $transaction = Transaction::where('trans_id', $transactionId)->firstOrFail();

        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => $transaction->trans_id,
                'gross_amount' => $transaction->amount,
            ],
            'customer_details' => [
                'name' => $transaction->nama,
                'email' => $transaction->email,
                'phone' => $transaction->phone,
            ],
        ];

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        return view('pos.payment', compact('transaction', 'snapToken'));
    }

    public function notification(Request $request)
{
    $notif = new \Midtrans\Notification();

    $transactionStatus = $notif->transaction_status;
    $orderId = $notif->order_id;

    $transaction = Transaction::where('trans_id', $orderId)->first();

    if ($transaction) {
        if ($transactionStatus == 'settlement') {
            $transaction->update(['status' => 'paid']);
        } elseif ($transactionStatus == 'pending') {
            $transaction->update(['status' => 'pending']);
        } elseif ($transactionStatus == 'expire' || $transactionStatus == 'cancel') {
            $transaction->update(['status' => 'failed']);
        }
    }

    return response()->json(['success' => true]);
}

public function updateStatus(Request $request)
{
    $transaction = Transaction::where('trans_id', $request->order_id)->first();
    if ($transaction) {
        $transaction->update(['status' => $request->status]);
    }
    return response()->json(['success' => true]);
}
}
