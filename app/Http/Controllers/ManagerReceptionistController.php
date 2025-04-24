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
use App\Services\BanService;
use Illuminate\Support\Facades\Log;

class ManagerReceptionistController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        // $this->authorize('viewAny', User::class);
        
        $user = Auth::user();
        $isAdmin = $user->hasRole('Admin');
        
        // Base query
        $query = User::role('receptionist');
        
        // If not admin, only show own data for receptionist
        if ($isAdmin) {
            // Admin can see all receptionists
            $query->with(['creator' => function($query) {
                $query->select('id', 'name');
            }]);
        } 
        else if ($user->hasRole('manager')) {
            // Manager can see receptionists they created
            $query->where('created_by', $user->id)
                ->with(['creator' => function($query) {
                    $query->select('id', 'name');
                }]);
        }
        else 
        {
            abort(403, 'Unauthorized action.'); // or redirect to a different page
        }
        
        $receptionists = $query->paginate(10);
        
        return Inertia::render('Manager/Receptionists/Index', [
            'receptionists' => $receptionists->through(fn($user) => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'created_at' => $user->created_at->diffForHumans(),
                'banned_at' => $user->banned_at?->toDateTimeString(),
            ]),
            'isAdmin' => $isAdmin,
            'userRole' => $user->roles->first()->name ?? 'none'
        ]);
    }

    public function create()
    {
       // $this->authorize('create', User::class);
         return Inertia('Manager/Receptionists/Create');
        
    }

    public function store(Request $request)
    {
        $myAcc = Auth::user();
        if (!$myAcc->hasRole('Admin') && !$myAcc->hasRole('manager')) {
            abort(403, 'Unauthorized action.');
        }

       // $this->authorize('create', User::class);
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

        $user->save();

        return redirect()->route('manager.receptionists.index')->with('success', 'Receptionist created!');
    }

    public function edit(User $receptionist)
    {
       // $this->authorize('update', $receptionist);
        return Inertia('Manager/Receptionists/Edit', [
        'receptionist' => $receptionist
        ]);
    }

    public function update(Request $request, User $receptionist)
    {
        $myAcc = Auth::user();
        if (!$myAcc->hasRole('Admin') && !$myAcc->hasRole('manager')) {
            abort(403, 'Unauthorized action.');
        }
     //   $this->authorize('update', $receptionist);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $receptionist->id,
            'national_id' => 'required|unique:users,national_id,' . $receptionist->id,
            'password' => 'nullable|string|min:6',
            'avatar_image' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

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

        return redirect()->route('manager.receptionists.index');
    }

    public function destroy(User $receptionist)
    {
        $myAcc = Auth::user();
        if (!$myAcc->hasRole('Admin') && !$myAcc->hasRole('manager')) {
            abort(403, 'Unauthorized action.');
        }
       // $this->authorize('delete', $receptionist);

        if ($receptionist->avatar_image !== 'default-avatar.jpg') {
            Storage::disk('public')->delete($receptionist->avatar_image);
        }

        $receptionist->delete();

        return redirect()->back();
    }

    public function toggleBan(User $receptionist)
    {
        $myAcc = Auth::user();
        if (!$myAcc->hasRole('Admin') && !$myAcc->hasRole('manager')) {
            abort(403, 'Unauthorized action.');
        }
      //  $this->authorize('toggleBan', $receptionist);
    //  \Log::info('Toggling ban for user: ' . $receptionist->id);
      if ($receptionist->isBanned()) {
        $receptionist->unban();
    } else {
        $receptionist->ban([
            'user_id' => Auth::id(), // Set the banning user
            'comment' => 'Banned by manager',
        ]);
    }

    }
}

