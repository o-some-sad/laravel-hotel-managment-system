<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\ReceptionistController;
use App\Http\Controllers\ManageReceptionistController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\FloorManagerController;
use App\Http\Controllers\ManagerReceptionistController;
use App\Models\User;
use Spatie\Permission\Middleware\RoleMiddleware;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\StripeController;



Route::get('/', function () {
    return Inertia::render('LandingPage', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard/Index');
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
    Route::get('/managers', [ManagerReceptionistController::class, 'index'])->name('managers.index');
});


Route::middleware(['auth', 'role:receptionist'])->group(function () {
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
});

Route::middleware('auth' ,'role:manager|Admin')->group(function() {
    Route::post('/managers/{user}/ban', [ManagerController::class, 'ban'])->name('managers.ban');
    Route::get('/dashboard/floors', [FloorManagerController::class,'index'])->name('floor.index');
    Route::get('/dashboard/addFloor', [FloorManagerController::class,'create'])->name('floor.create');
    Route::post('/dashboard/storeFloor', [FloorManagerController::class, 'store'])->name('floor.store');
    Route::get('/dashboard/editFloor/{id}', [FloorManagerController::class, 'edit'])->name('floor.edit');
    Route::put('/dashboard/updateFloor/{id}', [FloorManagerController::class, 'update'])->name('floor.update');
    Route::delete('/dashboard/delFloor/{id}', [FloorManagerController::class, 'delete'])->name('floor.delete');
});


// Route::prefix('manager')->middleware(['auth', 'role:manager'])->group(function () {
//     Route::resource('receptionists', ManagerReceptionistController::class)->except(['show']);
//     Route::post('/receptionists/{receptionist}/toggle-ban', [ManagerReceptionistController::class, 'toggleBan'])->name('receptionists.toggle-ban');
// });

// Route::get('/receptionists/{user}', function (User $user) {
//     return Inertia::render('Receptionist/Show', [
//         'receptionist' => $user
//     ]);
// })->middleware(['auth', \App\Http\Middleware\CheckReceptionistOwnership::class]);


// Receptionist Management routes
Route::prefix('manager')->middleware(['auth', 'role:manager'])->group(function () {
    // Show Receptionist routes
    Route::get('/receptionists', [ManagerReceptionistController::class, 'index'])
        ->name('manager.receptionists.index');

    // Create Receptionist routes
    Route::get('/receptionists/create', [ManagerReceptionistController::class, 'create'])
        ->name('manager.receptionists.create');
    Route::post('/receptionists', [ManagerReceptionistController::class, 'store'])
        ->name('manager.receptionists.store');

    // Edit Receptionist routes
    Route::get('/receptionists/{receptionist}/edit', [ManagerReceptionistController::class, 'edit'])
        ->name('manager.receptionists.edit');
    Route::put('/receptionists/{receptionist}', [ManagerReceptionistController::class, 'update'])
        ->name('manager.receptionists.update');

    // Delete Receptionist routes
    Route::delete('/receptionists/{receptionist}', [ManagerReceptionistController::class, 'destroy'])
        ->name('manager.receptionists.destroy');

    // Ban Receptionist routes
    Route::post('/receptionists/{receptionist}/toggle-ban', [ManagerReceptionistController::class, 'toggleBan'])
        ->name('receptionists.toggle-ban');
});

// Route::post('/managers/{user}/ban', [ManagerReceptionistController::class, 'ban'])->name('managers.ban');


// Room management routes
Route::middleware(['auth', 'role:manager|Admin'])->group(function () {
    Route::get('/dashboard/rooms', [RoomController::class, 'index'])->name('rooms.index');
    Route::get('/dashboard/rooms/create', [RoomController::class, 'create'])->name('rooms.create');
    Route::post('/dashboard/rooms', [RoomController::class, 'store'])->name('rooms.store');
    Route::get('/dashboard/rooms/{room}/edit', [RoomController::class, 'edit'])->name('rooms.edit');
    Route::put('/dashboard/rooms/{room}', [RoomController::class, 'update'])->name('rooms.update');
    Route::delete('/dashboard/rooms/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy');
});

// Manager routes - only accessible by admin
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/dashboard/managers', [ManagerController::class, 'index'])->name('managers.index');
    Route::get('/dashboard/managers/create', [ManagerController::class, 'create'])->name('managers.create');
    Route::post('/dashboard/managers', [ManagerController::class, 'store'])->name('managers.store');
    Route::get('/dashboard/managers/{manager}/edit', [ManagerController::class, 'edit'])->name('managers.edit');
    Route::put('/dashboard/managers/{manager}', [ManagerController::class, 'update'])->name('managers.update');
    Route::delete('/dashboard/managers/{manager}', [ManagerController::class, 'destroy'])->name('managers.destroy');
});

//client reservation routes
Route::middleware(['auth'])->group(function () {
    //	List of client's reservations
    Route::get('/client/reservations', [ReservationController::class, 'index'])
        ->name('client.reservations.index');
    //List of available rooms
    Route::get('/client/rooms', [ReservationController::class, 'availableRooms'])
        ->name('reservations.index');
    //Form to type accompany number and pay
    Route::get('/client/reservations/rooms/{room}', [ReservationController::class, 'create'])
        ->name('reservations.create');
        Route::post('/reservations/rooms/{room}', [ReservationController::class, 'store'])->name('reservations.store');
});

// Admin-only Receptionist Management routes
Route::middleware(['auth', 'role:Admin'])->prefix('dashboard')->group(function () {
    // Receptionists routes
    Route::get('/receptionists', [ManageReceptionistController::class, 'adminIndex'])
        ->name('dashboard.receptionists.index');
    Route::get('/receptionists/create', [ManageReceptionistController::class, 'adminCreate'])
        ->name('dashboard.receptionists.create');
    Route::post('/receptionists', [ManageReceptionistController::class, 'adminStore'])
        ->name('dashboard.receptionists.store');
    Route::get('/receptionists/{receptionist}/edit', [ManageReceptionistController::class, 'adminEdit'])
        ->name('dashboard.receptionists.edit');
    Route::put('/receptionists/{receptionist}', [ManageReceptionistController::class, 'adminUpdate'])
        ->name('dashboard.receptionists.update');
    Route::delete('/receptionists/{receptionist}', [ManageReceptionistController::class, 'adminDestroy'])
        ->name('dashboard.receptionists.destroy');
  
});


// Route::get('/checkout', [StripeController::class, 'showCheckout'])->name('stripe.checkout');
Route::get('/create-checkout-session/{reservation}', [StripeController::class, 'createCheckoutSession'])->name('stripe.session');
Route::get('/success', [StripeController::class, 'success'])->name('stripe.success');
Route::get('/cancel', [StripeController::class, 'cancel'])->name('stripe.cancel');

require __DIR__.'/auth.php';

