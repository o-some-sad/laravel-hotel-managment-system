<?php

namespace App\Observers;

use App\Models\Floor;

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

    public function deleted(Floor $floor): void
    {
        //
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
