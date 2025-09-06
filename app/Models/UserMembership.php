<?php

namespace App\Models;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class UserMembership extends Model
{

    protected $fillable = [
        'user_id', 'membership_id', 'start_date', 'end_date', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }


    protected static function booted()
    {
        static::creating(function ($user_membership) {
            if (empty($user_membership->rfid_code)) {
                $now = Carbon::now();
                $year = $now->year;
                $dayMonth = $now->format('dm');
                $random = strtoupper(Str::random(4));
                $user_membership->rfid_code = "OSB-{$year}-{$dayMonth}-{$random}";
            }
        });
    }
}
