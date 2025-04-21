<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'client_id',
        'room_id',
        'accompany_number',
        'paid_price',
        'approved_by',
        'start_date',
        'end_date',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
    
    /**
     * Get the paid price in dollars.
     */
    public function getPaidPriceInDollarsAttribute()
    {
        return $this->paid_price / 100;  // /100 as paid_price is saved in db in cents but it needs to be shown in dollars (mentioned in project requirements)
    }
}