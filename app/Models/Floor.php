<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Room;

class Floor extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'created_by'];

    protected static function booted()
    {
     
    }

    public function delete()
    {
    if ($this->rooms()->exists()) {
        throw new \Exception('Cannot delete floor with rooms');
        }
        parent::delete();
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
