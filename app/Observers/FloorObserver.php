<?php

namespace App\Observers;

use App\Models\Floor;
// use Illuminate/Container/Attributes/Log;

class FloorObserver
{
    public function creating(Floor $floor): void
    {
    // take the last floor number and increment by 1
    if (empty($floor->number)) {
            $lastFloor = Floor::orderBy('number', 'desc')->first();
            $floor->number = $lastFloor ? $lastFloor->number + 1000 : 1000;
    // MUST start with 1000
        if ($floor->number < 1000) {
            throw new \Exception("Floor number must be at least 4 digits");
        }
    }

    }

    public function updated(Floor $floor): void
    {
    // NO editing of floor number
        if ($floor->isDirty('number')) {
            abort(403, 'Cannot modify floor number!');
        }
    }

    public function deleting(Floor $floor): void
    {
        if ($floor->rooms()->count() > 0) {
            // Log::warning('Attempted to delete floor #' . $floor->number . ' with existing rooms', [
            //     'floor_id' => $floor->id,
            //     'room_count' => $floor->rooms()->count()
            // ]);
            abort(403, "Can't delete floor as there are rooms assigned to it");
        }
    }

    public function restored(Floor $floor): void
    {
        //
    }

    public function forceDeleted(Floor $floor): void
    {
        //
    }
}
