<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\FloorManagerController;


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
});

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/managers', [ManagerController::class, 'index'])->name('managers.index');
});

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

require __DIR__.'/auth.php';
