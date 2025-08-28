<?php

namespace App\Http\Controllers;

use App\Models\TrainerBooking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrainerBookingController extends Controller
{
    public function create()
    {
        // Ambil semua trainer
        $trainers = User::where('role', 'personal trainer')->get();
        $users = User::where('role', 'user')->get();
        return view('bookings.create', compact('trainers', 'users'));
    }

    public function store(Request $request)
    {
         $rules = [
        'trainer_id' => 'required|exists:users,id',
        'schedule' => 'required|date',
        'notes' => 'nullable|string',
        ];

        // Kalau admin → wajib pilih user
        if (auth()->user()->role === 'admin') {
            $rules['user_id'] = 'required|exists:users,id';
        }

    $validated = $request->validate($rules);

        TrainerBooking::create([
            'user_id' => auth()->user()->role === 'admin' ? $validated['user_id'] : auth()->id(),
            'trainer_id' => $request->trainer_id,
            'schedule' => $request->schedule,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);

        return redirect()->route('trainer.dashboard')->with('success', 'Booking berhasil dibuat!');
    }

    public function trainerDashboard(Request $request)
    {
        $query = TrainerBooking::with(['user', 'trainer']);

    if (auth()->user()->role === 'user') {
        // User → hanya lihat booking miliknya
        $query->where('user_id', auth()->id());
    } elseif (auth()->user()->role === 'personal trainer') {
        // Trainer → hanya lihat booking yang ditujukan ke dia
        $query->where('trainer_id', auth()->id());
    } else {
        // Admin → bisa filter
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        if ($request->filled('trainer_id')) {
            $query->where('trainer_id', $request->trainer_id);
        }
    } 

    $bookings = $query->latest()->paginate(10);

    // Data untuk dropdown filter (hanya admin)
    $users = User::where('role', 'user')
    ->whereHas('bookings') // hanya ambil user yang punya relasi booking
    ->get();
    $trainers = User::where('role', 'personal trainer')->get();

    return view('trainer.dashboard', compact('bookings', 'users', 'trainers'));
    }
}
