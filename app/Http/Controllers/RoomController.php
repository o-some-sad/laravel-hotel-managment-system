<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Floor;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RoomController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the rooms.
     */
    public function index()
    {
        $user = Auth::user();
        $isAdmin = $user->hasRole('Admin');
       
        // If admin, show all rooms with manager info
        // If manager, show only rooms created by this manager
        $query = Room::with('floor');
        
        if (!$isAdmin) {
            $query->where('created_by', $user->id);
        } else {
            $query->with('creator');
        }
        
        $rooms = $query->paginate(12);
        
        return Inertia::render('Dashboard/Rooms/Index', [
            'rooms' => $rooms,
            'isAdmin' => $isAdmin,
            'userId' => $user->id
        ]);
    }

    /**
     * Show the form for creating a new room.
     */
    public function create()
    {
        $floors = Floor::all();
        
        return Inertia::render('Dashboard/Rooms/Create', [
            'floors' => $floors
        ]);
    }

    /**
     * Store a newly created room in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'number' => ['required', 'string', 'min:4', 'unique:rooms,number'],
            'capacity' => ['required', 'integer', 'min:1'],
            'price' => ['required', 'numeric', 'min:0.01'],
            'floor_id' => ['required', 'exists:floors,id'],
            // 'image' => ['required', 'image', 'max:2048'],
        ]);
        
        $validated['price'] = (int)($validated['price'] * 100);
        $validated['created_by'] = Auth::id();
        
        // $uploadedFileUrl = Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();
        // if ($request->hasFile('image')) {


        //     $uploadedFile = $request->file('image');
        //     $result = Cloudinary::upload($uploadedFile->getRealPath(), [
        //         'folder' => 'rooms'
        //     ]);
            
        //     $validated['image_url'] = $result->getSecurePath();
        // }
        // $validated['image_url'] = $uploadedFileUrl;
        
        Room::create($validated);
        
        return redirect()->route('rooms.index')->with('success', 'Room created successfully');
    }

    /**
     * Show the form for editing the specified room.
     */
    public function edit(Room $room)
    {
        $this->authorize('update', $room);
        
        $floors = Floor::all();
        
        return Inertia::render('Dashboard/Rooms/Edit', [
            'room' => $room,
            'floors' => $floors
        ]);
    }

    /**
     * Update the specified room in storage.
     */
    public function update(Request $request, Room $room)
    {
        $this->authorize('update', $room);
        
        $validated = $request->validate([
            'number' => ['required', 'string', 'min:4', Rule::unique('rooms')->ignore($room->id)],
            'capacity' => ['required', 'integer', 'min:1'],
            'price' => ['required', 'numeric', 'min:0.01'],
            'floor_id' => ['required', 'exists:floors,id'],
            // 'image' => ['nullable', 'image', 'max:2048'],
        ]);
        
        $validated['price'] = (int)($validated['price'] * 100);
        
        // if ($request->hasFile('image')) {
        //     $uploadedFile = $request->file('image');
        //     $result = Cloudinary::upload($uploadedFile->getRealPath(), [
        //         'folder' => 'rooms'
        //     ]);
            
        //     $validated['image_url'] = $result->getSecurePath();
        // }
        
        $room->update($validated);
        
        return redirect()->route('rooms.index')->with('success', 'Room updated successfully');
    }

    /**
     * Remove the specified room from storage.
     */
    public function destroy(Room $room)
    {
        $this->authorize('delete', $room);
        
        // Check if room has reservations
        if ($room->reservations()->exists()) {
            return back()->with('error', 'Cannot delete room with existing reservations');
        }
        
        $room->delete();
        
        return back()->with('success', 'Room deleted successfully');
    }
}