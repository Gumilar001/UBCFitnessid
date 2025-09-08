<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Checkin extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shift_id',
        'checkin_time',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

    public function userMembership()
    {
        return $this->belongsTo(UserMembership::class, 'user_id', 'user_id');
    }
}
