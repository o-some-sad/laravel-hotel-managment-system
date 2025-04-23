<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Notifications\ClientApprovedNotification;


class ReceptionistController extends Controller
{
    /**
     * Display pending clients (not approved).
    */
    public function pendingClients()
    {
        $pendingClients = User::whereNull('approved_at')
                              ->whereHas('roles', fn($q) => $q->where('name', 'client'))
                              ->with('roles')
                              ->paginate(5);

        return Inertia::render('Receptionist/PendingClients', [
            'pendingClients' => $pendingClients
        ]);
    }

    /**
     * Approve a client.
     */
    public function approveClient(User $user)
    {
        if ($user->hasRole('client') && is_null($user->approved_at)) {
            $user->approved_at = now();
            $user->approved_by = Auth::id();
            $user->save();

            // Send approval notification (this should be implemented in a job/queue as specified)
            $user->notify(new ClientApprovedNotification());

            return redirect()->back()->with('success', 'Client approved successfully.');
        }

        return redirect()->back()->with('error', 'Unable to approve this client.');
    }


    /**
     * Display approved clients by this receptionist.
     */
    public function approvedClients()
    {
        $approvedClients = User::where('approved_by', Auth::id())
                               ->whereNotNull('approved_at')
                               ->whereHas('roles', fn($q) => $q->where('name', 'client'))
                               ->paginate(5);

        return Inertia::render('Receptionist/ApprovedClients', [
            'approvedClients' => $approvedClients
        ]);
    }

    /**
     * Display reservations for clients approved by this receptionist.
     */
    public function clientsReservations()
    {
        $reservations = Reservation::whereHas('client', function($query) {
                            $query->where('approved_by', Auth::id());
                        })
                        ->with(['client', 'room'])
                        ->paginate(5);

        return Inertia::render('Receptionist/ClientsReservations', [
            'reservations' => $reservations
        ]);
    }

}
