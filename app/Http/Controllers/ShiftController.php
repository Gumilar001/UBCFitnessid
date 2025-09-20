<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shift;
use App\Models\Transaction;
// use App\Models\Product;

class ShiftController extends Controller
{
    //
    public function index()
    {
        $user = auth()->user();
        $currentShift = Shift::where('receptionist_id', $user->id)
            ->whereNull('end_time')
            ->first();

        return view('shift.index', compact('currentShift'));
    }

    public function reportShift(Request $request)
    {
        $query = Transaction::with('shift');

// Pencarian berdasarkan nama atau email
if ($request->filled('search')) {
    $query->where(function ($q) use ($request) {
        $q->where('nama', 'like', '%' . $request->search . '%')
          ->orWhere('email', 'like', '%' . $request->search . '%');
    });
}

// Filter berdasarkan jenis pembayaran
if ($request->filled('shift') && $request->shift !== 'all') {
    $query->where('shift', $request->shift);
}

// Panggil latest sebelum get() untuk memastikan urutan berdasarkan created_at atau kolom lainnya
$transactions = $query->latest()->paginate(10)->withQueryString();

$shifts = ['Pagi', 'Sore'];

return view('shift.report', compact('transactions', 'shifts'));

    }

    public function open(Request $request)
    {
        $user = auth()->user();

        // Cek apakah ada shift yang masih terbuka
        $activeShift = Shift::where('receptionist_id', $user->id)
            ->whereNull('end_time')
            ->first();

        if ($activeShift) {
            return back()->with('error', 'Anda masih punya shift yang aktif.');
        }

        Shift::create([
            'receptionist_id' => $user->id,
            'shift_type' => $request->shift_type, // pagi / sore
            'start_time' => now(),
        ]);

        return redirect()->route('pos.index')->with('success', 'Shift berhasil dibuka.');
    }

    public function close()
    {
        $user = auth()->user();

        $activeShift = Shift::where('receptionist_id', $user->id)
            ->whereNull('end_time')
            ->first();

        if (!$activeShift) {
            return back()->with('error', 'Tidak ada shift yang aktif.');
        }

        $activeShift->update([
            'end_time' => now(),
        ]);

        return redirect()->route('shift.index')->with('success', 'Shift berhasil ditutup.');
    }
}
