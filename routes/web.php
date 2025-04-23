<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\ReceptionistController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\FloorManagerController;
use App\Http\Controllers\ManagerReceptionistController;
use App\Models\User;
use Spatie\Permission\Middleware\RoleMiddleware;

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
    Route::get('/managers', [ManagerReceptionistController::class, 'index'])->name('managers.index');
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

require __DIR__.'/auth.php';