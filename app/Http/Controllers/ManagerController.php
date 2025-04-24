<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ManagerController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $managers = User::role('manager')
            ->with('roles')
            ->get();

        return Inertia::render('Dashboard/Managers/Index', [
            'managers' => $managers
        ]);
    }

    public function create()
    {
        return Inertia::render('Dashboard/Managers/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', 'min:6'],
            'national_id' => 'required|string|unique:users',
            'avatar_image' => 'nullable|image|mimes:jpg,jpeg|max:2048',
        ]);

        DB::transaction(function () use ($request) {
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'national_id' => $request->national_id,
            ];

            // Handle avatar image upload
            if ($request->hasFile('avatar_image')) {
                $path = $request->file('avatar_image')->store('avatars', 'public');
                $userData['avatar_image'] = $path;
            }

            $user = User::create($userData);
            $user->assignRole('manager');
        });

        return redirect()->route('managers.index')->with('success', 'Manager created successfully');
    }

    public function edit(User $manager)
    {
        return Inertia::render('Dashboard/Managers/Edit', [
            'manager' => $manager
        ]);
    }

    public function update(Request $request, User $manager)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $manager->id,
            'national_id' => 'required|string|unique:users,national_id,' . $manager->id,
            'avatar_image' => 'nullable|image|mimes:jpg,jpeg|max:2048',
        ];

        if ($request->filled('password')) {
            $rules['password'] = ['required', 'confirmed', 'min:6'];
        }

        $request->validate($rules);

        $userData = $request->only(['name', 'email', 'national_id']);

        // Handle avatar image upload
        if ($request->hasFile('avatar_image')) {
            // Delete old avatar if exists
            if ($manager->avatar_image && Storage::disk('public')->exists($manager->avatar_image)) {
                Storage::disk('public')->delete($manager->avatar_image);
            }
            
            $path = $request->file('avatar_image')->store('avatars', 'public');
            $userData['avatar_image'] = $path;
        }

        $manager->update($userData);

        if ($request->filled('password')) {
            $manager->update([
                'password' => Hash::make($request->password)
            ]);
        }

        return redirect()->route('managers.index')->with('success', 'Manager updated successfully');
    }

    public function destroy(User $manager)
    {
        // Delete avatar if exists
        if ($manager->avatar_image && Storage::disk('public')->exists($manager->avatar_image)) {
            Storage::disk('public')->delete($manager->avatar_image);
        }
        
        $manager->delete();
        return redirect()->route('managers.index')->with('success', 'Manager deleted successfully');
    }

    public function ban(User $user)
    {
        $user->ban();
        return back();
    }
}
