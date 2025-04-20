<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
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
}
