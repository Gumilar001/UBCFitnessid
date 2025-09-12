<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    //
    protected $fillable = [
        'code', 'type', 'value', 'start_date', 'end_date', 'usage_limit', 'used', 'status'
    ];

    public function isValid()
    {
        if ($this->end_date && now()->gt($this->end_date)) {
            return false;
        }
        if ($this->usage_limit > 0 && $this->used >= $this->usage_limit) {
            return false;
        }
        return true;
    }
}
