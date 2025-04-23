<?php

namespace App\Policies;

use App\Models\Room;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RoomPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Room $room)
    {
        return $user->hasRole('admin') || $room->created_by === $user->id;
    }

    public function delete(User $user, Room $room)
    {
        return $user->hasRole('admin') || $room->created_by === $user->id;
    }
}