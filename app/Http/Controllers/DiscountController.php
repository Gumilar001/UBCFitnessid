<?php

namespace App\Http\Controllers;
use App\Models\Discount;
use App\Models\Membership;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    // Menampilkan daftar diskon
    public function index()
    {
        $discounts = Discount::with('membership')->get();
        return view('discounts.index', compact('discounts'));
    }

    // Form tambah diskon
    public function create()
    {
        $memberships = Membership::all();
        return view('discounts.create', compact('memberships'));
    }

    // Simpan diskon baru
    public function store(Request $request)
    {
        $request->validate([
            'membership_id' => 'required|exists:memberships,id',
            'name' => 'required|string|max:255',
            'type' => 'required|in:percent,nominal',
            'value' => 'required|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        Discount::create($request->all());

        return redirect()->route('discounts.index')->with('success', 'Diskon berhasil dibuat.');
    }

    // Form edit diskon
    public function edit(Discount $discount)
    {
        $memberships = Membership::all();
        return view('discounts.edit', compact('discount', 'memberships'));
    }

    // Update diskon
    public function update(Request $request, Discount $discount)
    {
        $request->validate([
            'membership_id' => 'required|exists:memberships,id',
            'name' => 'required|string|max:255',
            'type' => 'required|in:percent,nominal',
            'value' => 'required|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $discount->update($request->all());

        return redirect()->route('discounts.index')->with('success', 'Diskon berhasil diupdate.');
    }

    // Hapus diskon
    public function destroy(Discount $discount)
    {
        $discount->delete();
        return redirect()->route('discounts.index')->with('success', 'Diskon berhasil dihapus.'); 
    }
}
