<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    //
    public function __construct()
    {
        // Konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false; // set true kalau sudah live
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    // 1. Buat order dan dapatkan Snap Token
    public function createTransaction(Request $request)
    {
        $orderId = uniqid(); // bisa juga pakai UUID

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $request->amount,
            ],
            'customer_details' => [
                'first_name' => 'Customer',
                'email' => 'customer@mail.com',
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        // Simpan transaksi awal
        Transaction::create([
            'order_id' => $orderId,
            'status' => 'pending',
            'gross_amount' => $request->amount,
        ]);

        return response()->json(['snap_token' => $snapToken, 'order_id' => $orderId]);
    }

    // 2. Callback Midtrans (server → server)
    public function notificationHandler(Request $request)
    {
        $notif = new \Midtrans\Notification();

        $transaction = Transaction::where('order_id', $notif->order_id)->first();

        if ($transaction) {
            $transaction->transaction_id = $notif->transaction_id;
            $transaction->payment_type = $notif->payment_type;
            $transaction->status = $notif->transaction_status;
            $transaction->save();
        }

        return response()->json(['status' => 'ok']);
    }

    // 3. Simpan manual dari client (opsional)
    public function storeResult(Request $request)
    {
        $transaction = Transaction::where('order_id', $request->order_id)->first();

        if ($transaction) {
            $transaction->transaction_id = $request->transaction_id;
            $transaction->payment_type = $request->payment_type;
            $transaction->status = $request->transaction_status;
            $transaction->save();
        }

        return response()->json(['success' => true]);
    }
}
