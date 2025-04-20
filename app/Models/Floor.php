<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Room;

class Floor extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'number','created_by'];

    protected static function booted()
    {
     
    }

    public function delete()
    {
    // can't delete a floor if there are rooms in it
    if ($this->rooms()->exists()) {
        throw new \Exception('Cannot delete floor with rooms');
        }
        parent::delete();
    }

    public function creator()
    {
        // floor belongs to which manager (who created this floor)
        return $this->belongsTo(User::class, 'created_by');
    }

    public function rooms()
    {
    // one floor has many rooms
        return $this->hasMany(Room::class);
    }
}
