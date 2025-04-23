<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Reservation;
use App\Models\Room;
use Inertia\Inertia;

class StripeController extends Controller
{
    public function showCheckout()
    {
        return view('checkout');
    }

    public function createCheckoutSession(Request $request, Reservation $reservation)
    {
        $room = Room::findOrFail($reservation->room_id);
        $roomName = $room->name ?? 'Room Booking';
        
        $amount = $reservation->paid_price; 
        
        Stripe::setApiKey(config('services.stripe.secret'));
    
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $roomName,
                        'description' => 'Booking for ' . $reservation->accompany_number . ' guest(s)',
                    ],
                    'unit_amount' => $amount,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}&reservation_id=' . $reservation->id,
            'cancel_url' => route('stripe.cancel') . '?reservation_id=' . $reservation->id,
            'metadata' => [
                'reservation_id' => $reservation->id
            ],
        ]);
    
        // For Inertia requests, return a special response
        if ($request->header('X-Inertia')) {
            return Inertia::location($session->url);
        }
    
        // For traditional requests
        return redirect()->away($session->url);
    }

    
    public function success(Request $request)
    {
        $sessionId = $request->get('session_id');
        $reservationId = $request->get('reservation_id');
    
        if (!$sessionId) {
            return redirect()->route('stripe.cancel')->with('error', 'Missing session ID.');
        }
    
        Stripe::setApiKey(config('services.stripe.secret'));
    
        $session = \Stripe\Checkout\Session::retrieve($sessionId);
    
        if ($session->payment_status !== 'paid') {
            // return view('success', ['session' => $session]);
            return redirect()->route('stripe.cancel')->with('error', 'Payment not successful.');
        }
        $reservation = Reservation::findOrFail($reservationId);
        if($reservation->payment_status === 'paid'){
            return Inertia::location(route('client.reservations.index', [
                'success' => 'Payment successful! Your room has been reserved.',
            ]));
        }

        $reservation->update([
            'payment_status' => 'paid',
        ]);
    
        $room = $reservation->room;
        $room->is_reserved = true;
        $room->reserved_by = $reservation->client_id;
        $room->save();
        
        return Inertia::location(route('client.reservations.index', [
            'success' => 'Payment successful! Your room has been reserved.',
        ]));
}

    public function cancel()
    {
        return view('cancel');
    }
}