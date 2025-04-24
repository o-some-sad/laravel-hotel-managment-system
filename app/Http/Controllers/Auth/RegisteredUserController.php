<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use App\Http\Requests\ClientRegisterRequest;
use Inertia\Response;
use Lwwcas\LaravelCountries\Models\Country;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        // $countries = Country::select('id', 'official_name')
        // ->where('is_visible', 1)
        // ->get();


        $countries = Country::with('translations')
            ->where('is_visible', 1)
            ->get()
            ->sortBy('translations.0.name')
            ->values();
            
        return Inertia::render('Auth/Register', [
            'countries' => $countries,
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(ClientRegisterRequest $request): RedirectResponse
    {
        $avatarPath = $request->hasFile('avatar_image')
        ? $request->file('avatar_image')->store('avatars', 'public')
        : 'avatars/default.jpg';

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request['password']),
            'country_code' => $request['country'],
            'gender' => $request['gender'],
            'avatar_image' => $avatarPath,
        ]);
        $user->assignRole('client');

        event(new Registered($user));

        // Auth::login($user); // prevent login automatically after registration

        return redirect('/');
    }
}
