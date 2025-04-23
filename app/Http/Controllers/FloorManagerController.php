<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Floor;
use App\Models\User;
use App\Http\Requests\FloorManagerRequest;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;


class FloorManagerController extends Controller
{
    //
    public function create()
    {
        $addFloor = Floor::all();
        return Inertia::render('FloorManager/Create', [
            'floors' => $addFloor
        ]);
    }

    public function store(FloorManagerRequest $request)
    {
        // dd($request->all());
        $validatedCol = $request->validated();
        try{
            Floor::create([
                'name'=> $validatedCol['name'],
                'created_by' => Auth::id()
                // 'created_by'=> $validatedCol['created_by']
            ]);
            return redirect()
            ->route('floor.index');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Floor creation failed. Please try again.');
        }
    }
    // public function show($id){
    //     // show a SINGLE floor
    //     $getFloor = Floor::findOrFail($id);
    //     //  ** VIEW-NAME **
    //     return view('floors.create',['floors'=>$getFloor]);
    // }

    public function index(){
        $currentUser = User::find(Auth::id());
        // used eager-loading to get the creator's name
        $allFloors = Floor::with('creator:id,name')->get();
        
        if($currentUser->hasRole('Admin')){
            return Inertia::render('FloorManager/Index', [
                'floors' => $allFloors,
                'isAdmin' => true,
                'userId' => Auth::id()
            ]);
        }   
        
        return Inertia::render('FloorManager/Index', [
            'floors' => $allFloors,
            // 'isAdmin' => $currentUser->hasRole('admin'),
            'isManager' => true,
            // 'isManager' => $currentUser->hasRole('Manager'),
            'userId' => Auth::id() 
        ]);
    }

    public function edit($id){
        // edit a floor
        $floorID = Floor::findOrFail($id);
        return Inertia::render('FloorManager/Edit', [
            'floor' => $floorID
        ]);
    }
    public function update($id, FloorManagerRequest $request){
        $validatedCol = $request->validated();
        try{
        $editFloorById=Floor::find($id);
        $editFloorById->name = $validatedCol['name'];
        $editFloorById->save();
        return redirect()
            ->route('floor.index');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Floor editing failed. Please try again.');
        }
    }
    
    public function delete($id){
        try{
            $floor = Floor::findOrFail($id);
            $floor->delete();
            return redirect()
            ->route('floor.index');
        } catch (\Exception $e) {
            return redirect()
            ->route('floor.index')
            ->with('error', 'This floor cannot be deleted because it has rooms assigned to it. Please remove all rooms first.');
        }
    }
}
