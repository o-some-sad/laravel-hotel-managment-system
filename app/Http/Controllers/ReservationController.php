<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ReservationController extends Controller
{

    public function index()
    {
        $reservations = Reservation::where('client_id', Auth::id())
            ->with('room')
            ->paginate(10);

            return Inertia::render('Client/Reservations', [
                'data' => $reservations->items(),
                'meta' => [
                    'current_page' => $reservations->currentPage(),
                    'last_page' => $reservations->lastPage(),
                    'per_page' => $reservations->perPage(),
                    'total' => $reservations->total(),
                ],
                'links' => [
                    'next' => $reservations->nextPageUrl(),
                    'prev' => $reservations->previousPageUrl(),
                ],
            ]);
    }

    // Show the reservation form for the selected room.
    public function create(Room $room)
    {
        return Inertia::render('Client/MakeReservation', [
            'room' => $room,
        ]);
    }

    //Handle the reservation submission.
    public function store(Request $request, Room $room)
    {
        $request->validate([
            'accompany_number' => 'required|integer|min:1|max:' . $room->capacity,
        ]);

        // Calculate price
        $totalPriceCents = $room->price; // price stored as cents in database

        // Create reservation (NOT paid yet)
        $reservation = Reservation::create([
            'client_id' => Auth::id(),
            'room_id' => $room->id,
            'accompany_number' => $request->accompany_number,
            'paid_price' => $totalPriceCents,
        ]);

        // Later after successful Stripe checkout, we update it as paid

        // (Temporary) redirect to reservations page (we will soon connect Stripe)
        return redirect()->route('stripe.session', ['reservation' => $reservation]);
    }
    public function availableRooms()
    {
        $rooms = Room::where('is_reserved', false)->paginate(10);

        return Inertia::render('Client/AvailableRooms', [
            'rooms' => [
                'data' => $rooms->items(),
                'meta' => [
                    'current_page' => $rooms->currentPage(),
                    'last_page' => $rooms->lastPage(),
                    'per_page' => $rooms->perPage(),
                    'total' => $rooms->total(),
                ],
                'links' => [
                    'next' => $rooms->nextPageUrl(),
                    'prev' => $rooms->previousPageUrl(),
                ],
            ],
        ]);
    }
}
