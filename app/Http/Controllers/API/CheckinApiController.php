<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserMembership;
use App\Models\Checkin;
use App\Models\Shift;

class CheckinApiController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'rfid_code' => 'required|string',
            'device' => 'nullable|string',
            'shift_id' => 'nullable|integer|exists:shifts,id'
        ]);

        $rfid = trim($request->rfid_code);

        $userMembership = UserMembership::with('user','membership')
            ->where('rfid_code', $rfid)
            ->first();

        if (!$userMembership) {
            return response()->json(['success'=>false,'message'=>'RFID not registered'], 404);
        }

        // optional: check membership active
        if ($userMembership->status !== 'active' 
            || ($userMembership->end_date && now()->gt($userMembership->end_date)))
        {
            return response()->json(['success'=>false,'message'=>'Membership not active'], 403);
        }

        // get shift: prefer passed shift_id, else find active shift for device user (customize)
        $shift = null;
        if ($request->shift_id) {
            $shift = Shift::find($request->shift_id);
        } else {
            // example: find any active shift (adapt to your logic)
            $shift = Shift::whereNull('end_time')->first();
        }

        $checkin = Checkin::create([
            'user_id' => $userMembership->user_id,
            'shift_id' => $shift ? $shift->id : null,
            'checkin_time' => now(),
            'device' => $request->device,
        ]);

        return response()->json([
            'success'=>true,
            'message'=>'Check-in recorded',
            'data' => [
                'name' => $userMembership->user->name,
                'membership' => $userMembership->membership->name ?? null,
                'checkin_id' => $checkin->id
            ]
        ]);
    }
}
