<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'floor_id',
        'number',
        'capacity',
        'price',
        'image_url',
        'created_by'
    ];

    public function floor()
    {
        return $this->belongsTo(Floor::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
    
    /**
     * Get the price in dollars.
     */
    public function getPriceInDollarsAttribute()
    {
        return $this->price / 100;
    }
}
