<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\ReceptionistController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

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

require __DIR__.'/auth.php';