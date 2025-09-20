<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'trans_id','nama', 'membership_id','email','phone','emergency_contact','gender','golongan_darah','identitas','amount', 'jenis_pembayaran', 'paid_at', 'shift_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }
    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }
}
