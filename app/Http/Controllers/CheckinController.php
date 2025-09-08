<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Checkin;
use App\Models\User;
use App\Models\UserMembership;
use App\Models\Shift;

class CheckinController extends Controller
{
    //
    public function index()
    {
        $checkins = Checkin::with(['userMembership.user', 'shift'])
            ->latest()
            ->get();

        return view('checkins.index', compact('checkins'));
    }

    public function store(Request $request)
    {
        $request->validate([
        'rfid_code' => 'required|string',
    ]);

    // Cari userMembership berdasarkan RFID
    $userMembership = UserMembership::where('rfid_code', $request->rfid_code)->first();

    if (!$userMembership) {
        return response()->json([
            'success' => false,
            'message' => 'Kartu tidak dikenali!'
        ]);
    }

    // Cari shift aktif receptionist
    $currentShift = Shift::where('receptionist_id', auth()->id())
        ->whereNull('end_time')
        ->first();

    if (!$currentShift) {
        return response()->json([
            'success' => false,
            'message' => 'Shift belum dibuka.'
        ]);
    }

    // Simpan checkin
    $checkin = Checkin::create([
        'user_id' => $userMembership->user_id,
        'shift_id' => $currentShift->id,
        'checkin_time' => now(),
    ]);

    return response()->json([
        'success' => true,
        'message' => "Berhasil check-in: " . $userMembership->user->name,
        'data' => $checkin
    ]);
}

}
