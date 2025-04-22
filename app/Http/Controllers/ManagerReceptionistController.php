<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Receptionist; 
use App\Models\User; 
use App\Models\Manager;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ManagerReceptionistController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $receptionists =  User::role('receptionist')
        ->where('created_by', Auth::id())
        ->with(['creator' => function($query) {
            $query->select('id', 'name');
        }])
            ->paginate(10);

            return Inertia::render('Manager/Receptionists/Index', [
                'receptionists' => $receptionists->through(fn($user) => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'created_at' => $user->created_at->diffForHumans()
                ])
            ]);
    }

    public function create()
    {
        $this->authorize('create', User::class);
         return Inertia::render('Manager/Receptionists/Create');
        
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'national_id' => 'required|unique:users,national_id',
            'avatar_image' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'national_id' => $request->national_id,
            'created_by' => Auth::id(),
            'avatar_image' => $request->file('avatar_image') ? 
                $request->file('avatar_image')->store('public/avatars') : 'default.jpg'
        ]);

        $user->assignRole('receptionist');
        
        if ($request->hasFile('avatar_image')) {
            $user->avatar_image = $request->file('avatar_image')->store('avatars');
        } else {
            $user->avatar_image = 'default-avatar.jpg'; 
        }
        $user->save();

        return Inertia::render('Manager/Receptionists/Create');
    }

    public function edit(User $receptionist)
    {
        $this->authorize('update', $receptionist);
        return Inertia::render('Manager/Receptionists/Edit', [
        'receptionist' => $receptionist
        ]);
    }

    public function update(Request $request, User $receptionist)
    {
        $this->authorize('update', $receptionist);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $receptionist->id,
            'national_id' => 'required|unique:users,national_id,' . $receptionist->id,
            'password' => 'nullable|string|min:6',
            'avatar_image' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        $receptionist->update($request->except('avatar'));

        if ($request->password) {
            $receptionist->password = bcrypt($request->password);
        }

        if ($request->hasFile('avatar_image')) {
            $receptionist->avatar_image = $request->file('avatar_image')->store('avatars');
        }

        $receptionist->save();

        return Inertia::render('Manager/Receptionists/Edit', [
            'receptionist' => $receptionist
        ]);
    }

    public function destroy(User $receptionist)
    {
        $this->authorize('delete', $receptionist);
        $receptionist->delete();
        return back();
    }

    public function toggleBan(User $receptionist)
    {
        $this->authorize('update', $receptionist);
        $receptionist->isBanned() ? $receptionist->unban() : $receptionist->ban();
        return redirect()->back();
    }
}
