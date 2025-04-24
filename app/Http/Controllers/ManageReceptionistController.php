<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class ManageReceptionistController extends Controller
{
    // ... existing methods for receptionist functionality ...

    // Admin methods for managing receptionists
    public function adminIndex()
    {
        $receptionists = User::role('receptionist')
            ->with('roles')
            ->paginate(12);

        return Inertia::render('Dashboard/Receptionists/Index', [
            'receptionists' => $receptionists
        ]);
    }

    public function adminCreate()
    {
        return Inertia::render('Dashboard/Receptionists/Create');
    }

    public function adminStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'national_id' => 'required|string|max:20|unique:users',
            'avatar_image' => 'nullable|image|mimes:jpg,jpeg|max:2048',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'national_id' => $request->national_id,
        ]);

        // Handle avatar upload
        if ($request->hasFile('avatar_image')) {
            $path = $request->file('avatar_image')->store('avatars', 'public');
            $user->avatar_image = Storage::url($path);
            $user->save();
        }

        // Assign receptionist role
        $user->assignRole('receptionist');

        return redirect()->route('dashboard.receptionists.index')
            ->with('success', 'Receptionist created successfully');
    }

    public function adminEdit(User $receptionist)
    {
        // Check if user has receptionist role
        if (!$receptionist->hasRole('receptionist')) {
            abort(404);
        }

        return Inertia::render('Dashboard/Receptionists/Edit', [
            'receptionist' => $receptionist
        ]);
    }

    public function adminUpdate(Request $request, User $receptionist)
    {
        // Check if user has receptionist role
        if (!$receptionist->hasRole('receptionist')) {
            abort(404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $receptionist->id,
            'password' => $request->password ? ['confirmed', Rules\Password::defaults()] : '',
            'national_id' => 'required|string|max:20|unique:users,national_id,' . $receptionist->id,
            'avatar_image' => 'nullable|image|mimes:jpg,jpeg|max:2048',
        ]);

        $receptionist->name = $request->name;
        $receptionist->email = $request->email;
        $receptionist->national_id = $request->national_id;
        
        if ($request->password) {
            $receptionist->password = Hash::make($request->password);
        }

        // Handle avatar upload
        if ($request->hasFile('avatar_image')) {
            // Delete old avatar if exists
            if ($receptionist->avatar_image) {
                $oldPath = str_replace('/storage/', '', $receptionist->avatar_image);
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }
            
            $path = $request->file('avatar_image')->store('avatars', 'public');
            $receptionist->avatar_image = Storage::url($path);
        }

        $receptionist->save();

        return redirect()->route('dashboard.receptionists.index')
            ->with('success', 'Receptionist updated successfully');
    }

    public function adminDestroy(User $receptionist)
    {
        // Check if user has receptionist role
        if (!$receptionist->hasRole('receptionist')) {
            abort(404);
        }

        // Delete avatar if exists
        if ($receptionist->avatar_image) {
            $path = str_replace('/storage/', '', $receptionist->avatar_image);
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }

        $receptionist->delete();

        return redirect()->route('dashboard.receptionists.index')
            ->with('success', 'Receptionist deleted successfully');
    }

}