<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voucher;

class VoucherController extends Controller
{
    //
    public function index()
    {
        $vouchers = Voucher::all();
        return view('vouchers.index', compact('vouchers'));
    }

    public function create()
    {
        return view('vouchers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code'       => 'required|string|unique:vouchers,code',
            'type'       => 'required|in:percent,fixed',
            'value'      => 'required|numeric|min:1',
            'start_date' => 'nullable|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
        ]);

        Voucher::create([
            'code'       => strtoupper($request->code),
            'type'       => $request->type,
            'value'      => $request->value,
            'start_date' => $request->start_date,
            'end_date'   => $request->end_date,
            'active'     => true,
        ]);

        return redirect()->route('vouchers.index')->with('success', 'Voucher berhasil dibuat.');
    }

    public function edit(Voucher $voucher)
    {
        return view('vouchers.edit', compact('voucher'));
    }

    public function update(Request $request, Voucher $voucher)
    {
        $request->validate([
            'code'       => 'required|string|unique:vouchers,code',
            'type'       => 'required|in:percent,fixed',
            'value'      => 'required|numeric|min:1',
            'start_date' => 'nullable|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
        ]);

        $voucher->update([
            'code'       => strtoupper($request->code),
            'type'       => $request->type,
            'value'      => $request->value,
            'start_date' => $request->start_date,
            'end_date'   => $request->end_date,
            'active'     => true,
        ]);

        return redirect()->route('vouchers.index')->with('success', 'Voucher berhasil diperbarui.');
    } 
}
