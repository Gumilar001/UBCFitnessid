<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Membership;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {        
        $query = Transaction::query();
        
        // Pencarian berdasarkan nama atau email
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        // Filter berdasarkan jenis pembayaran
        if ($request->filled('jenis_pembayaran') && $request->jenis_pembayaran !== 'all') {
            $query->where('jenis_pembayaran', $request->jenis_pembayaran);
        }

        $transactions = $query->latest()->paginate(10)->withQueryString();
        $metodes = ['BNI', 'BCA', 'QRIS'];

        return view('transactions.index', compact('transactions', 'metodes'));
    }

    public function create()
    {
        $users = User::where('role', 'user')->get();
        $memberships = Membership::all();
        return view('transactions.create', compact('users', 'memberships'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'membership_id' => 'required|exists:memberships,id',
            'amount' => 'required|numeric',
            'jenis_pembayaran' => 'nullable|string|max:255',
            'paid_at' => 'required|date',
        ]);
        Transaction::create($request->all());
        return redirect()->route('transactions.index')->with('success', 'Transaction created!');
    }

    public function edit(Transaction $transaction)
    {
        $users = User::all();
        $memberships = Membership::all();
        return view('transactions.edit', compact('transaction', 'users', 'memberships'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'membership_id' => 'required|exists:memberships,id',
            'amount' => 'required|numeric',
            'jenis_pembayaran' => 'nullable|string|max:255',
            'paid_at' => 'required|date',
        ]);
        $transaction->update($request->all());
        return redirect()->route('transactions.index')->with('success', 'Transaction updated!');
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return redirect()->route('transactions.index')->with('success', 'Transaction deleted!');
    }
    public function myTransactions()
    {
        $transactions = Transaction::where('user_id', auth()->id())->get();
        return view('users.transactions.index', compact('transactions'));
    }
}