<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    //
    protected $fillable = [
        'membership_id', 'name', 'type', 'value',
        'start_date', 'end_date', 'status'
    ];

    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }
}
