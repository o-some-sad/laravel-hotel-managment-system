<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ban extends Model 
{

    protected $fillable = [
        'user_id', 
        'comment',
        'expired_at'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
