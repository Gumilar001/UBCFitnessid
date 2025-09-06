<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Shift extends Model
{
    //
    protected $fillable = ['receptionist_id', 'shift_type', 'start_time', 'end_time'];

    public function receptionist()
    {
        return $this->belongsTo(User::class, 'receptionist_id');
    }
    
}
