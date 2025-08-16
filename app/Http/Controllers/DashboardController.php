<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Contoh asumsi: tabel transactions ada field amount & type (income/expense)
        
        $jumlahPengguna = User::where('role', 'user')
            ->count();

        $pendapatanBulanan = Transaction::where('jenis_pembayaran', 'transfer')
            ->whereMonth('created_at', now()->month)
            ->sum('amount');

        $pembayaran = Transaction::where('jenis_pembayaran', 'cash')
            ->whereMonth('created_at', now()->month)
            ->sum('amount');

        $pengeluaran = Transaction::where('jenis_pembayaran', 'credit card')
            ->whereMonth('created_at', now()->month)
            ->sum('amount');

        // Data grafik per bulan (1 tahun terakhir)
        $incomeByMonth = Transaction::selectRaw('MONTH(created_at) as bulan, SUM(amount) as total')
            ->where('jenis_pembayaran', 'transfer')
            ->whereYear('created_at', now()->year)
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        $expenseByMonth = Transaction::selectRaw('MONTH(created_at) as bulan, SUM(amount) as total')
            ->where('jenis_pembayaran', 'cash')
            ->whereYear('created_at', now()->year)
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        return view('dashboard', [
            'pendapatanBulanan' => $pendapatanBulanan,
            'pembayaran' => $pembayaran,
            'pengeluaran' => $pengeluaran,
            'incomeByMonth' => $incomeByMonth,
            'expenseByMonth' => $expenseByMonth,
            'jumlahPengguna' => $jumlahPengguna,
        ]);

    }
}
