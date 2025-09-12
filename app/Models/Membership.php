<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    protected $fillable = ['name', 'duration', 'price'];

    public function userMemberships()
    {
        return $this->hasMany(UserMembership::class);
    }
     public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    public function discounts()
    {
        return $this->hasMany(Discount::class);
    }

}
