<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Membership;

class POSController extends Controller
{


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
        ]);

        $currentShift = Shift::where('receptionist_id', auth()->id())
            ->whereNull('end_time')
            ->first();
        if (!$currentShift) {
            return redirect()->route('shift.index')->with('error', 'Silakan buka shift dulu.');
        }

        // Jika membership_id kosong → cari "Visit"
        $membershipId = $request->membership_id;
        if (!$membershipId) {
            $visitMembership = Membership::where('name', 'VISIT')->first();
            if ($visitMembership) {
                $membershipId = $visitMembership->id;
            }
        }

        // Jika type membership, buat user baru jika belum ada
        if ($request->type === 'membership') {
            $user = User::where('email', $request->email)->first();
            if (!$user && $request->email) {
                $user = User::create([
                    'name' => $request->nama,
                    'email' => $request->email,
                    'password' => Hash::make('12345678'), // default password, bisa diganti
                    'no_hp' => $request->phone,
                    'no_emergency' => $request->emergency_contact,
                    'role' => 'user',
                ]);
            }
        }

        $transaction = Transaction::create([
            'trans_id' => $request->trans_id,
            'nama' => $request->nama,
            'membership_id' => $membershipId,
            'email' => $request->email,
            'phone' => $request->phone,
            'emergency_contact' => $request->emergency_contact,
            'amount' => $request->total,
            'jenis_pembayaran' => null, // diisi saat pembayaran
            'paid_at' => now(), // isi dengan tanggal sekarang agar tidak null
            'shift_id' => $currentShift->id,
        ]);

        return redirect()->route('pos.index')->with('success', 'Transaksi berhasil disimpan.');
    }
    // Endpoint AJAX untuk ambil detail membership
    public function getMembershipDetail(Request $request)
    {
        $membership = \App\Models\Membership::find($request->membership_id);
        if (!$membership) {
            return response()->json(['error' => 'Membership tidak ditemukan'], 404);
        }
        // Diskon bisa diatur sesuai kebutuhan, misal dari request atau logic lain
        $diskon = $request->diskon ?? 0;
        return response()->json([
            'price' => $membership->price,
            'diskon' => $diskon,
            'name' => $membership->name,
            'duration' => $membership->duration
        ]);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transaction) {
            if (empty($transaction->trans_id)) {
                $transaction->trans_id = 'TRX-' . strtoupper(uniqid());
            }
        });
    }


    public function index()
    {

        // Generate trans_id sementara (bisa tampil di form)
        $transId = 'TRX-' . date('ymd') . '-' . mt_rand(1000, 9999);

        $memberships = Membership::all();

        // cari shift aktif
        $currentShift = Shift::where('receptionist_id', auth()->id())
            ->whereNull('end_time')
            ->first();

        if (!$currentShift) {
            return redirect()->route('shift.index')->with('error', 'Silakan buka shift dulu.');
        }

        return view('pos.index', compact('currentShift', 'memberships', 'transId'));
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


}
