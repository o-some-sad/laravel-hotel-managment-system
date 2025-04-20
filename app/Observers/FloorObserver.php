<?php

namespace App\Observers;

use App\Models\Floor;

class FloorObserver
{
    /**
     * Handle the Floor "created" event.
     */
    public function creating(Floor $floor): void
    {
        if (empty($floor->number)) {
            $lastFloor = Floor::orderBy('number', 'desc')->first();
            $floor->number = $lastFloor ? $lastFloor->number + 1 : 1001;
        

        if ($floor->number < 1000) {
            throw new \Exception("Floor number must be at least 4 digits");
        }
    }

    }

    /**
     * Handle the Floor "updated" event.
     */
    public function updated(Floor $floor): void
    {
        if ($floor->isDirty('number')) {
            abort(403, 'Cannot modify floor number!');
        }
    }

    /**
     * Handle the Floor "deleted" event.
     */
    public function deleted(Floor $floor): void
    {
        //
    }

    /**
     * Handle the Floor "restored" event.
     */
    public function restored(Floor $floor): void
    {
        //
    }

    /**
     * Handle the Floor "force deleted" event.
     */
    public function forceDeleted(Floor $floor): void
    {
        //
    }
}
