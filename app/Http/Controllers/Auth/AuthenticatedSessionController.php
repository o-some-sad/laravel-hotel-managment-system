<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\User;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();
        
        // Update the last_login_at timestamp for the authenticated user
        $user = Auth::user();

        if ($user instanceof \App\Models\User) {
            $user->last_login_at = now();
            $user->save();
        }

        // if ($user->hasRole('admin')) {
        //     return redirect()->route('managers.index');
        // } elseif ($user->hasRole('manager')) {
        //     return redirect()->route('manager.receptionists.index');
        // } elseif ($user->hasRole('receptionist')) {
        //     return redirect()->route('receptionist.pending-clients');
        // }
        

        return redirect('/user/dashboard');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
