<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Receptionist; 
use App\Models\User; 
use App\Models\Manager;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;

class ManagerReceptionistController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $this->authorize('viewAny', User::class);
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
                    'created_at' => $user->created_at->diffForHumans(),
                    'banned_at' => $user->banned_at?->toDateTimeString(),
                ])
            ]);
    }

    public function create()
    {
        $this->authorize('create', User::class);
         return Inertia('Manager/Receptionists/Create');
        
    }

    public function store(Request $request)
    {
        $this->authorize('create', User::class);
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
                $request->file('avatar_image')->store('avatars', 'public') : 'default.jpg'
        ]);

        $user->assignRole('receptionist');
        
        if ($request->hasFile('avatar_image')) {
            $user->avatar_image = $request->file('avatar_image')->store('avatars');
        } else {
            $user->avatar_image = 'default-avatar.jpg'; 
        }
        $user->save();

        return redirect()->route('manager.receptionists.index');
    }

    public function edit(User $receptionist)
    {
        $this->authorize('update', $receptionist);
        return Inertia('Manager/Receptionists/Edit', [
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

        if ($request->hasFile('avatar_image')) {
            if ($receptionist->avatar_image !== 'default-avatar.jpg') {
                Storage::disk('public')->delete($receptionist->avatar_image);
            }
            $avatarPath = $request->file('avatar_image')->store('avatars', 'public');
        } else {
            $avatarPath = $receptionist->avatar_image;
        }

        $receptionist->update([
            'name' => $request->name,
            'email' => $request->email,
            'national_id' => $request->national_id,
            'avatar_image' => $avatarPath,
        ]);

        $receptionist->save();

        return redirect()->route('manager.receptionists.index');
    }

    public function destroy(User $receptionist)
    {
        $this->authorize('delete', $receptionist);

        if ($receptionist->avatar_image !== 'default-avatar.jpg') {
            Storage::disk('public')->delete($receptionist->avatar_image);
        }

        $receptionist->delete();

        return redirect()->back();
    }

    public function toggleBan(User $receptionist)
    {
        $this->authorize('toggleBan', $receptionist);
        $receptionist->isBanned() ? $receptionist->unban() : $receptionist->ban();
        return redirect()->back();
    }
}
