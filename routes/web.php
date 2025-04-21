<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\ReceptionistController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ReservationController;

Route::get('/', function () {
    return Inertia::render('LandingPage', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Add this to your existing routes
    Route::get('/user/dashboard', function () {
        return Inertia::render('User/Dashboard');
    })->name('user.dashboard');

});

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/managers', [ManagerController::class, 'index'])->name('managers.index');
});


//Route::middleware(['auth', 'receptionist'])->group(function () {
    // Pending clients route
    Route::get('/clients/pending', [ReceptionistController::class, 'pendingClients'])
        ->name('receptionist.pending-clients');
    
    // Approve client route
    Route::post('/clients/{user}/approve', [ReceptionistController::class, 'approveClient'])
        ->name('receptionist.approve-client');
    
    // My approved clients route
    Route::get('/clients/approved', [ReceptionistController::class, 'approvedClients'])
        ->name('receptionist.approved-clients');
    
    // Clients reservations route
    Route::get('/clients/reservations', [ReceptionistController::class, 'clientsReservations'])
        ->name('receptionist.clients-reservations');
//});

Route::post('/managers/{user}/ban', [ManagerController::class, 'ban'])->name('managers.ban');

Route::middleware('auth')->group(function () {
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/rooms', [ReservationController::class, 'availableRooms'])->name('reservations.available_rooms');
    Route::get('/reservations/rooms/{roomId}', [ReservationController::class, 'showRoomForm'])->name('reservations.room_form');
    Route::post('/reservations/rooms/{roomId}', [ReservationController::class, 'makeReservation'])->name('reservations.make');
    Route::get('/reservations/payment/{reservationId}', [ReservationController::class, 'paymentPage'])->name('reservation.payment');
    Route::post('/reservations/payment/{reservationId}', [ReservationController::class, 'processPayment'])->name('reservation.process_payment');
});
require __DIR__.'/auth.php';
