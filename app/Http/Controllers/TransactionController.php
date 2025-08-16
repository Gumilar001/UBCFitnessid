<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Membership;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['user', 'membership'])->get();
        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $users = User::all();
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