<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\ReceptionistController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\FloorManagerController;
use App\Http\Controllers\RoomController;


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
Route::middleware('auth')->group(function() { 
    Route::get('/floors', [FloorManagerController::class,'index'])->name('floor.index');});
Route::middleware('auth')->group(function(){
    Route::get('/addFloor', [FloorManagerController::class,'create'])->name('floor.create');
});
Route::middleware('auth')->group(function () {
    Route::post('/storeFloor', [FloorManagerController::class, 'store'])->name('floor.store');
});
Route::middleware('auth')->group(function(){
    Route::get('/editFloor/{id}', [FloorManagerController::class,'edit'])->name('floor.edit');
});
Route::middleware('auth')->group(function () {
    Route::put('/updateFloor/{id}', [FloorManagerController::class, 'update'])->name('floor.update');
});
Route::middleware('auth')->group(function () {
    Route::delete('/delFloor/{id}', [FloorManagerController::class, 'delete'])->name('floor.delete');
});

// Room management routes
Route::middleware(['auth' /*,'role:manager|admin'*/])->group(function () {
    Route::get('/dashboard/rooms', [RoomController::class, 'index'])->name('rooms.index');
    Route::get('/dashboard/rooms/create', [RoomController::class, 'create'])->name('rooms.create');
    Route::post('/dashboard/rooms', [RoomController::class, 'store'])->name('rooms.store');
    Route::get('/dashboard/rooms/{room}/edit', [RoomController::class, 'edit'])->name('rooms.edit');
    Route::put('/dashboard/rooms/{room}', [RoomController::class, 'update'])->name('rooms.update');
    Route::delete('/dashboard/rooms/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy');
});

require __DIR__.'/auth.php';